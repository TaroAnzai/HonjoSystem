# current_system_overview.md

# 本庄工場システム 現行構成概要

## 概要

本システムは、本庄工場における自動倉庫・PLC・Windows端末間のデータ連携を行うための業務システムである。

システム全体は Linux（Slackware 14.1）上で稼働しており、以下の構成で動作している。

* PHP
* PostgreSQL
* Samba
* inetd
* 独自TCPサーバー（uplink/server.php）
* SMB共有フォルダ連携

システムの特徴として、データベース中心ではなく「SMB共有フォルダを利用したファイル連携」が重要な役割を持っている。

---

# OS / ミドルウェア

## OS

* Slackware 14.1
* USBブート構成

## 使用ミドルウェア

| 種類           | 内容         |
| ------------ | ---------- |
| Web / Script | PHP        |
| DB           | PostgreSQL |
| ファイル共有       | Samba      |
| TCP待受        | inetd      |
| バージョン管理      | svnserve   |

---

# ディレクトリ構成

## アプリケーション

```text
/home/project/bcinfo/www
```

## PostgreSQL

```text
/home/staff/postgres
```

## Samba

```text
/usr/local/samba4
```

---

# TCPサーバー構成

## inetd.conf

```text
uplink stream tcp nowait daemon:daemon /usr/local/bin/php -q /home/project/bcinfo/www/uplink/server.php SV
```

## 概要

inetd 経由で PHP を起動し、`server.php` が TCP通信を処理している。

現在確認されているモード：

| モード | 用途                       |
| --- | ------------------------ |
| SV  | サーバーモード                  |
| CL  | テストまたはクライアントモード（未使用の可能性） |

---

# データ連携方式

## PLC連携

KEYENCE PLC と連携。

通信データは主にファイルとして共有フォルダへ配置される。

## SMB共有

自動倉庫制御PCやWindows端末は Samba共有を参照している。

共有フォルダ名が業務プロトコルの一部になっている可能性が高い。

例：

```php
define( "NAC_STORAGE_WASH" , "SENNYUKO" );
define( "NAC_STORAGE_PRODUCT" , "SEINYUKO" );
```

---

# PostgreSQL

## 用途

* 業務データ管理
* ログ管理
* 状態管理

ただし、本システムではDBよりもファイル共有連携の重要度が高い。

---

# Samba

## 用途

* Windows共有
* PLC連携用ファイル共有
* 自動倉庫PC連携

## 備考

Samba AD/DC（Active Directory Domain Controller）を利用している可能性がある。

現在調査済み：

* smb.conf
* rc.d
* samba4ディレクトリ

---

# システムの特徴

本システムは一般的なWebシステムではなく、工場制御寄りの構成である。

特徴：

* SMB共有ベース
* ファイル連携中心
* TCPサーバー型PHP
* PLC連携
* 自動倉庫連携
* 高可用性重視
* 長期安定稼働前提

---
