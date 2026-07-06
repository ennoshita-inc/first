#!/bin/zsh
# コラム アイキャッチ自動生成ランナー（毎朝8:30 / launchd: com.ennoshita.column-eyecatch）
cd "$HOME/Developer/GitHub/first/eyecatch"
/usr/bin/python3 batch_eyecatch.py >> "$HOME/.config/claude-runner/logs/column-eyecatch.log" 2>&1
