# future_modernization_plan.md

# 将来的なシステム近代化計画

# 目的

現行PHP + Samba + PostgreSQL構成を、保守性・可搬性・拡張性の高い構成へ段階的に移行する。

---

# 現在の課題

| 項目    | 課題           |
| ----- | ------------ |
| OS    | Slackware保守性 |
| PHP   | 古い構成         |
| inetd | 現代的ではない      |
| Samba | 設定複雑化        |
| デプロイ  | 手動           |
| ログ    | 分散           |
| 監視    | 未整備          |

---

# 目標構成

## アプリケーション

| 現在    | 将来                  |
| ----- | ------------------- |
| PHP   | Flask               |
| inetd | systemd             |
| 手動起動  | Docker              |
| 個別ログ  | centralized logging |

---

# Flask化

# 基本方針

既存PHPを一括変換せず、段階的に Flask へ置換する。

---

# Flask候補構成

| 項目         | 技術                  |
| ---------- | ------------------- |
| API        | Flask               |
| ORM        | SQLAlchemy          |
| Migration  | Flask-Migrate       |
| Validation | Marshmallow         |
| Task       | Celery              |
| Auth       | Flask-Login または JWT |

---

# 想定ディレクトリ

```text
backend/
frontend/
docker-compose.yml
```

---

# Docker化

# 目的

* 可搬性向上
* バックアップ容易化
* 復旧容易化
* テスト環境再現
* CI/CD対応

---

# 想定構成

| サービス    | 内容            |
| ------- | ------------- |
| backend | Flask         |
| db      | PostgreSQL    |
| samba   | Samba         |
| redis   | Celery        |
| nginx   | Reverse Proxy |

---

# Sambaについて

## 維持予定

工場システムでは SMB共有が重要なため、当面維持する。

## 将来的検討

* API連携化
* メッセージキュー化
* gRPC化

ただしPLC連携との互換性優先。

---

# 監視導入

候補：

* Netdata
* Prometheus
* Grafana

---

# ログ管理

候補：

* journalctl
* Loki
* ELK Stack

---

# セキュリティ

## SSH

* Tailscale
* VPN
* 公開鍵認証

## Samba

* ACL整理
* AD再構築検討

---

# 今後の段階計画

## Phase 1

Ubuntu移行。

## Phase 2

systemd化。

## Phase 3

Flask API新規作成。

## Phase 4

既存PHP置換。

## Phase 5

Docker化。

## Phase 6

監視・CI/CD整備。

---

# 最終目標

* 長期保守可能
* 再構築容易
* ドキュメント化
* 自動デプロイ
* 可観測性向上
* 工場停止リスク低減

---
