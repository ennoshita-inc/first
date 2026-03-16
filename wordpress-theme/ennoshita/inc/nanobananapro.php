<?php
/**
 * ナノバナナプロ（Gemini API）画像自動生成
 * APIキーは暗号化して保存
 *
 * @package Ennoshita
 */

/**
 * APIキーを暗号化して保存
 */
function ennoshita_encrypt_api_key($key) {
    if (empty($key)) return '';
    $salt = defined('AUTH_KEY') ? AUTH_KEY : 'ennoshita-fallback-salt';
    $method = 'aes-256-cbc';
    $iv_length = openssl_cipher_iv_length($method);
    $iv = substr(hash('sha256', defined('NONCE_KEY') ? NONCE_KEY : 'ennoshita-iv'), 0, $iv_length);
    return base64_encode(openssl_encrypt($key, $method, $salt, 0, $iv));
}

/**
 * 保存されたAPIキーを復号
 */
function ennoshita_decrypt_api_key($encrypted) {
    if (empty($encrypted)) return '';
    $salt = defined('AUTH_KEY') ? AUTH_KEY : 'ennoshita-fallback-salt';
    $method = 'aes-256-cbc';
    $iv_length = openssl_cipher_iv_length($method);
    $iv = substr(hash('sha256', defined('NONCE_KEY') ? NONCE_KEY : 'ennoshita-iv'), 0, $iv_length);
    $decrypted = openssl_decrypt(base64_decode($encrypted), $method, $salt, 0, $iv);
    return $decrypted !== false ? $decrypted : '';
}

/**
 * コラム保存時にアイキャッチ画像がなければ Gemini API で自動生成
 */
function ennoshita_nanobananapro_generate_image($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    if (get_post_status($post_id) === 'auto-draft') return;
    if (defined('REST_REQUEST') && REST_REQUEST) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (has_post_thumbnail($post_id)) return;

    // 暗号化済みキーを復号して使用
    $encrypted_key = get_option('ennoshita_nanobananapro_api_key_encrypted');
    $api_key = $encrypted_key ? ennoshita_decrypt_api_key($encrypted_key) : get_option('ennoshita_nanobananapro_api_key');
    if (!$api_key) return;

    $post  = get_post($post_id);
    $title = $post->post_title;
    if (!$title || $title === __('Auto Draft')) return;

    $excerpt = wp_trim_words(strip_tags($post->post_content), 50, '');

    $prompt = sprintf(
        'ビジネスブログ記事「%s」のアイキャッチ画像を生成してください。' .
        '記事の内容: %s。' .
        'スタイル: プロフェッショナルで洗練されたビジネスイラスト、' .
        '暖かみのある緑系のカラーパレット（#1a5632を基調）、' .
        '人材育成・組織開発のコンサルティング企業にふさわしいトーン。' .
        'テキストや文字は一切入れないでください。' .
        'アスペクト比は16:9（横長）で生成してください。',
        $title,
        $excerpt
    );

    $model = get_option('ennoshita_nanobananapro_model', 'gemini-2.0-flash-exp');
    $api_url = sprintf(
        'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
        $model,
        $api_key
    );

    $body = [
        'contents' => [
            [
                'parts' => [
                    ['text' => $prompt],
                ],
            ],
        ],
        'generationConfig' => [
            'responseModalities' => ['TEXT', 'IMAGE'],
        ],
    ];

    $response = wp_remote_post($api_url, [
        'timeout' => 60,
        'headers' => ['Content-Type' => 'application/json'],
        'body'    => wp_json_encode($body),
    ]);

    if (is_wp_error($response)) {
        error_log('ナノバナナプロ API エラー: ' . $response->get_error_message());
        return;
    }

    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        error_log('ナノバナナプロ API HTTPエラー: ' . $code . ' ' . wp_remote_retrieve_body($response));
        return;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    $image_data = null;
    $mime_type  = 'image/png';
    if (!empty($data['candidates'][0]['content']['parts'])) {
        foreach ($data['candidates'][0]['content']['parts'] as $part) {
            if (!empty($part['inlineData'])) {
                $image_data = $part['inlineData']['data'];
                $mime_type  = $part['inlineData']['mimeType'] ?? 'image/png';
                break;
            }
        }
    }

    if (!$image_data) {
        error_log('ナノバナナプロ: 画像データが見つかりません');
        return;
    }

    $decoded = base64_decode($image_data);
    if (!$decoded) return;

    $ext = ($mime_type === 'image/jpeg') ? '.jpg' : '.png';
    $filename = 'nanobananapro-' . $post_id . '-' . time() . $ext;
    $upload_dir = wp_upload_dir();
    $filepath   = $upload_dir['path'] . '/' . $filename;

    if (!file_put_contents($filepath, $decoded)) {
        error_log('ナノバナナプロ: ファイル保存に失敗');
        return;
    }

    $attachment = [
        'post_mime_type' => $mime_type,
        'post_title'     => sanitize_file_name($title) . ' - AI生成画像',
        'post_content'   => '',
        'post_status'    => 'inherit',
    ];

    $attach_id = wp_insert_attachment($attachment, $filepath, $post_id);
    if (is_wp_error($attach_id)) {
        error_log('ナノバナナプロ: アタッチメント登録に失敗');
        return;
    }

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $metadata = wp_generate_attachment_metadata($attach_id, $filepath);
    wp_update_attachment_metadata($attach_id, $metadata);

    set_post_thumbnail($post_id, $attach_id);
}
add_action('save_post_post', 'ennoshita_nanobananapro_generate_image', 20);

/**
 * 管理画面: ナノバナナプロAPIキー設定ページ
 */
function ennoshita_nanobananapro_settings_page() {
    add_options_page(
        'ナノバナナプロ設定',
        'ナノバナナプロ',
        'manage_options',
        'ennoshita-nanobananapro',
        'ennoshita_nanobananapro_settings_html'
    );
}
add_action('admin_menu', 'ennoshita_nanobananapro_settings_page');

function ennoshita_nanobananapro_settings_html() {
    if (!current_user_can('manage_options')) return;

    if (isset($_POST['_nanobananapro_nonce']) && wp_verify_nonce($_POST['_nanobananapro_nonce'], 'nanobananapro_settings')) {
        $raw_key = sanitize_text_field($_POST['api_key'] ?? '');
        // 暗号化して保存
        update_option('ennoshita_nanobananapro_api_key_encrypted', ennoshita_encrypt_api_key($raw_key));
        // 旧平文キーを削除（マイグレーション）
        delete_option('ennoshita_nanobananapro_api_key');
        update_option('ennoshita_nanobananapro_model', sanitize_text_field($_POST['model'] ?? 'gemini-2.0-flash-exp'));
        echo '<div class="notice notice-success"><p>設定を保存しました。</p></div>';
    }

    // 表示用: 暗号化キーがあれば復号、なければ旧キーを表示
    $encrypted_key = get_option('ennoshita_nanobananapro_api_key_encrypted');
    $api_key = $encrypted_key ? ennoshita_decrypt_api_key($encrypted_key) : get_option('ennoshita_nanobananapro_api_key', '');
    $model   = get_option('ennoshita_nanobananapro_model', 'gemini-2.0-flash-exp');
    ?>
    <div class="wrap">
        <h1>ナノバナナプロ（Gemini API）設定</h1>
        <p>コラム記事を保存する際、アイキャッチ画像が未設定の場合に Gemini API（ナノバナナプロ）で自動生成します。</p>
        <form method="post">
            <?php wp_nonce_field('nanobananapro_settings', '_nanobananapro_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="api_key">Gemini API キー</label></th>
                    <td>
                        <input type="password" id="api_key" name="api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text">
                        <p class="description">Google AI Studio で取得した API キーを入力してください。APIキーは暗号化して保存されます。</p>
                    </td>
                </tr>
                <tr>
                    <th><label for="model">モデル</label></th>
                    <td>
                        <select id="model" name="model">
                            <option value="gemini-2.0-flash-exp" <?php selected($model, 'gemini-2.0-flash-exp'); ?>>Gemini 2.0 Flash (Nano Banana)</option>
                            <option value="gemini-2.5-flash-preview-image" <?php selected($model, 'gemini-2.5-flash-preview-image'); ?>>Gemini 2.5 Flash (Nano Banana 2)</option>
                            <option value="gemini-3-pro-image-preview" <?php selected($model, 'gemini-3-pro-image-preview'); ?>>Gemini 3 Pro Image (Nano Banana Pro)</option>
                        </select>
                        <p class="description">使用する画像生成モデルを選択してください。Nano Banana Pro が最高品質です。</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('設定を保存'); ?>
        </form>
        <hr>
        <h2>使い方</h2>
        <ol>
            <li>Google AI Studio（<code>https://aistudio.google.com/</code>）でAPIキーを取得</li>
            <li>上のフォームにAPIキーを入力して保存</li>
            <li>コラム記事を作成・保存すると、アイキャッチ画像が未設定の場合に自動で画像が生成されます</li>
            <li>生成された画像はメディアライブラリに保存され、アイキャッチに設定されます</li>
        </ol>
        <p><strong>注意:</strong> 既にアイキャッチ画像が設定されている記事では画像は生成されません。再生成したい場合は、アイキャッチ画像を一度削除してから記事を更新してください。</p>
    </div>
    <?php
}
