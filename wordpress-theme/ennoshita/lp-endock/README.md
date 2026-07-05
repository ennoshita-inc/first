# lp-endock — 組織活力調査 endock LP

`https://ennoshita.co.jp/endock/` で公開する組織活力調査（endock）のランディングページ関連ファイル一式。

## このフォルダの構成

```
lp-endock/
├── CLAUDE.md         LP制作の指示書（design-system v1.3 + WordPress統合方針）
├── README.md         このファイル
├── tokens.css        design-system v1.3 のCSS変数（.lp-endock スコープで定義）
├── lp-endock.css     LP固有のスタイル
└── assets/
    ├── logo-primary.png    design-system/assets/ から複製
    └── images/             LP用画像（必要に応じて追加）
```

## ページテンプレート本体

`wordpress-theme/ennoshita/page-endock.php`（テーマルート直下）

WordPressテンプレート規約上、`page-*.php` はテーマルートに置く必要があるため、
LP本体テンプレートのみテーマルートに配置し、付随ファイル（CSS・画像）はこの `lp-endock/` 配下にまとめている。

## 設計方針

- **既存テーマへの影響ゼロ**：style.css / header.php / footer.php / 既存 page-*.php は変更しない
- **スコープ分離**：すべてのCSSは `.lp-endock` 下にネスト
- **デザインシステム v1.3 準拠**：カラー・タイポ・コンポーネント仕様を遵守
- **モバイル優先**：clamp() と @media でレスポンシブ対応

## 公開手順（管理画面側）

1. WordPress管理画面 → 固定ページ → 新規追加
2. タイトル：`endock 組織活力調査`
3. パーマリンク（slug）：`endock`
4. ページ属性 → テンプレート：`endock LP` を選択
5. 公開

## 更新履歴

| 日付 | バージョン | 内容 |
|---|---|---|
| 2026-05-03 | v1.0 | 初版作成（design-system v1.3 ベース） |
