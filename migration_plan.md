# migration_plan.md

# Ubuntu移行計画

# 目的

現行Slackwareシステムを Ubuntu Server 上へ移行する。

目的：

* ハードウェア老朽化対策
* OS保守性向上
* 将来的なFlask化の基盤構築
* Docker化への準備

---

# 基本方針

## 現行システムは残す

既存Slackware機は停止せず保存。

Ubuntu機を別PCとして構築し、動作確認後に切替を行う。

---

# 移行対象

| 対象         | 移行            |
| ---------- | ------------- |
| PostgreSQL | ○             |
| Samba      | ○             |
| PHP        | ○             |
| inetd      | △（systemd化予定） |
| 共有フォルダ     | ○             |
| PLC連携      | ○             |

---

# Ubuntu構成

## OS

* Ubuntu Server 24.04 LTS

## ミドルウェア

| 種類     | 構成         |
| ------ | ---------- |
| DB     | PostgreSQL |
| ファイル共有 | Samba      |
| PHP    | php-cli    |
| サービス管理 | systemd    |

---

# 作業手順

# 1. Ubuntuインストール

最小構成でインストール。

GUI不要。

---

# 2. ネットワーク設定

固定IP設定。

PLC・Windows端末と同一セグメントへ接続。

---

# 3. PostgreSQL移行

## dump取得

現行機：

```bash
pg_dump progress > progress.sql
```

## Ubuntu側

```bash
sudo -u postgres createdb progress
sudo -u postgres psql progress < progress.sql
```

---

# 4. PHP環境構築

```bash
sudo apt install php-cli
```

---

# 5. server.php 移行

配置例：

```text
/opt/bcinfo/www
```

---

# 6. systemd化

## uplink.service

```ini
[Unit]
Description=HONJO uplink server
After=network.target postgresql.service

[Service]
Type=simple
User=www-data
WorkingDirectory=/opt/bcinfo/www/uplink
ExecStart=/usr/bin/php /opt/bcinfo/www/uplink/server.php SV
Restart=always

[Install]
WantedBy=multi-user.target
```

---

# 7. Samba移行

## smb.conf移植

共有名を変更しないこと。

例：

```ini
[SEINYUKO]
path = /data/SEINYUKO
```

共有名はシステム連携に使用されている可能性がある。

---

# 8. 動作確認

## 優先確認

1. PostgreSQL
2. PHP
3. uplink/server.php
4. Samba共有
5. Windows接続
6. PLC通信
7. 自動倉庫連携

---

# 注意事項

## SMB共有名

変更禁止。

## ファイル配置

変更時は全連携先確認が必要。

## Samba AD/DC

AD/DC利用時は単純コピー不可。

---

# 切替方法

最終的に：

* Ubuntu機へLAN接続変更
* IP切替
* 動作確認

を行う。

---
