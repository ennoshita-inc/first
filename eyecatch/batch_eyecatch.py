#!/usr/bin/env python3
"""アイキャッチ未設定のコラム記事にGPT Image 2生成画像を一括設定"""
import json, os, re, sys, time, base64, subprocess, urllib.request, urllib.error

def load_env(path):
    d = {}
    for line in open(os.path.expanduser(path)):
        line = line.strip()
        if line and not line.startswith('#') and '=' in line:
            k, v = line.split('=', 1)
            d[k.strip()] = v.strip().strip('"').strip("'")
    return d

OPENAI_KEY = load_env('~/Developer/GitHub/ppt-handdrawn-converter/.env')['OPENAI_API_KEY']
wp_env = load_env(os.path.join(os.path.dirname(os.path.abspath(__file__)), '.env'))
WP_AUTH = base64.b64encode(f"{wp_env['WP_USER']}:{wp_env['WP_APP_PASSWORD']}".encode()).decode()
SITE = 'https://ennoshita.co.jp'
OUT = os.path.join(os.path.dirname(os.path.abspath(__file__)), 'out')

def api(url, data=None, headers=None, method=None, timeout=300, raw=False):
    req = urllib.request.Request(url, data=data, headers=headers or {}, method=method)
    res = urllib.request.urlopen(req, timeout=timeout)
    body = res.read()
    return body if raw else json.loads(body)

def gen_image(title, out_png):
    prompt = f"""日本のビジネスコラム記事のアイキャッチイラスト。テーマ:「{title}」

スタイル指定:
- 温かみのある手描き風のビジネスイラスト（水彩・色鉛筆タッチ）
- 落ち着いたえんじ色(#852228)とゴールド(#c49a2a)を基調に、クリーム色の背景
- 日本の中小企業のオフィス風景や働く人々を、親しみやすくシンプルに描く
- 抽象的・概念的な表現でテーマを象徴する（説明的すぎない）
- 文字・テキスト・ロゴは一切入れない
- 横長構図、余白を活かした上品なデザイン"""
    body = json.dumps({'model': 'gpt-image-2', 'prompt': prompt,
                       'size': '1536x1024', 'quality': 'high', 'n': 1}).encode()
    for attempt in range(5):
        try:
            res = api('https://api.openai.com/v1/images/generations', data=body,
                      headers={'Authorization': f'Bearer {OPENAI_KEY}', 'Content-Type': 'application/json'})
            open(out_png, 'wb').write(base64.b64decode(res['data'][0]['b64_json']))
            return True
        except urllib.error.HTTPError as e:
            print(f'  gen retry {attempt+1}: HTTP {e.code}', flush=True)
            if e.code in (429, 500, 502, 503, 520, 524):
                time.sleep(20 * (attempt + 1))
            else:
                print('  ', e.read()[:300], flush=True); raise
        except Exception as e:
            print(f'  gen retry {attempt+1}: {e}', flush=True); time.sleep(20)
    return False

def to_jpeg(png, jpg):
    subprocess.run(['sips', '-s', 'format', 'jpeg', '-s', 'formatOptions', '85', png, '--out', jpg],
                   check=True, capture_output=True)

def upload_media(jpg, post_id, title):
    """アップロード。ロリポップWAFの誤検知403時は再エンコードしてバイト列を変えて再試行（L-210）"""
    variants = [jpg]
    for q, w in [(80, 1400), (76, 1300)]:
        alt = jpg.replace('.jpg', f'_q{q}.jpg')
        src = jpg if os.path.exists(jpg) else None
        if src:
            subprocess.run(['sips', '-Z', str(w), '-s', 'format', 'jpeg',
                            '-s', 'formatOptions', str(q), src, '--out', alt],
                           capture_output=True)
            if os.path.exists(alt):
                variants.append(alt)
    media = None
    last_err = None
    for v in variants:
        try:
            data = open(v, 'rb').read()
            media = api(f'{SITE}/wp-json/wp/v2/media', data=data, headers={
                'Authorization': f'Basic {WP_AUTH}',
                'Content-Type': 'image/jpeg',
                'Content-Disposition': f'attachment; filename="column-eyecatch-{post_id}.jpg"',
            })
            break
        except urllib.error.HTTPError as e:
            last_err = e
            if e.code == 403:
                print(f'  upload 403 (WAF?) -> 再エンコードで再試行', flush=True)
                time.sleep(5)
                continue
            raise
    if media is None:
        raise last_err
    mid = media['id']
    meta = json.dumps({'alt_text': title, 'title': f'アイキャッチ: {title}'}).encode()
    api(f'{SITE}/wp-json/wp/v2/media/{mid}', data=meta,
        headers={'Authorization': f'Basic {WP_AUTH}', 'Content-Type': 'application/json'})
    return mid

def set_featured(post_id, media_id):
    api(f'{SITE}/wp-json/wp/v2/posts/{post_id}',
        data=json.dumps({'featured_media': media_id}).encode(),
        headers={'Authorization': f'Basic {WP_AUTH}', 'Content-Type': 'application/json'})

import datetime
print(f"===== {datetime.datetime.now().strftime('%Y-%m-%d %H:%M')} 実行 =====", flush=True)
# 公開済みだけでなく「予約（future）」も対象にする：公開前にアイキャッチを付けておけば、
# ジョブが動く時刻とPCの起動状態が公開時刻と無関係になる（2026-09-06）
posts = []
for st in ('publish', 'future'):
    posts += api(f'{SITE}/wp-json/wp/v2/posts?status={st}&per_page=100&_fields=id,title,featured_media,status&cb=' + str(int(time.time())),
                 headers={'Authorization': f'Basic {WP_AUTH}'})
targets = [p for p in posts if not p['featured_media']]
print(f'対象: {len(targets)}記事', flush=True)
ok, ng = 0, []
for p in targets:
    pid = p['id']
    title = re.sub(r'<[^>]+>', '', p['title']['rendered'])
    title = title.replace('&#8221;', '"').replace('&#8220;', '"').replace('&amp;', '&').replace('&#038;', '&')
    png = f'{OUT}/eyecatch_{pid}.png'
    jpg = f'{OUT}/eyecatch_{pid}.jpg'
    print(f'[{pid}] ({p.get("status","")}) {title[:45]}', flush=True)
    try:
        if pid == 1052 and os.path.exists(f'{OUT}/sample_1052.png'):
            png = f'{OUT}/sample_1052.png'  # 承認済みサンプルを再利用
        elif not os.path.exists(png):
            if not gen_image(title, png):
                raise RuntimeError('generation failed after retries')
        to_jpeg(png, jpg)
        mid = upload_media(jpg, pid, title)
        set_featured(pid, mid)
        print(f'  -> media {mid} 設定完了', flush=True)
        ok += 1
    except Exception as e:
        print(f'  !! 失敗: {e}', flush=True)
        ng.append(pid)
print(f'完了: 成功{ok} / 失敗{len(ng)} {ng}', flush=True)
