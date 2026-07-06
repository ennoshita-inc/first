#!/usr/bin/env python3
"""コラム記事のアイキャッチをGPT Image 2で1枚生成（サンプル）"""
import json, os, sys, base64, urllib.request

env = {}
for line in open(os.path.expanduser('~/Developer/GitHub/ppt-handdrawn-converter/.env')):
    line = line.strip()
    if line and not line.startswith('#') and '=' in line:
        k, v = line.split('=', 1)
        env[k.strip()] = v.strip().strip('"').strip("'")
KEY = env['OPENAI_API_KEY']

title = sys.argv[1]
prompt = f"""日本のビジネスコラム記事のアイキャッチイラスト。テーマ:「{title}」

スタイル指定:
- 温かみのある手描き風のビジネスイラスト（水彩・色鉛筆タッチ）
- 落ち着いたえんじ色(#852228)とゴールド(#c49a2a)を基調に、クリーム色の背景
- 日本の中小企業のオフィス風景や働く人々を、親しみやすくシンプルに描く
- 抽象的・概念的な表現でテーマを象徴する（説明的すぎない）
- 文字・テキスト・ロゴは一切入れない
- 横長構図、余白を活かした上品なデザイン"""

req = urllib.request.Request(
    'https://api.openai.com/v1/images/generations',
    data=json.dumps({
        'model': 'gpt-image-2',
        'prompt': prompt,
        'size': '1536x1024',
        'quality': 'high',
        'n': 1,
    }).encode(),
    headers={'Authorization': f'Bearer {KEY}', 'Content-Type': 'application/json'},
)
res = json.load(urllib.request.urlopen(req, timeout=300))
img = base64.b64decode(res['data'][0]['b64_json'])
out = sys.argv[2]
open(out, 'wb').write(img)
print('saved:', out, len(img), 'bytes')
