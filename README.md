# getTodayActiveTaskListByBacklog

バックログからその日対象アカウントが変更した課題のリストを抽出します。

作業報告等でご活用ください。

## 動作確認環境
PHP7.3

## 実行に際し必要な情報
### BacklogApiKey
https://support-ja.backlog.com/hc/ja/articles/360035641754-API%E3%81%AE%E8%A8%AD%E5%AE%9A

### 取得するユーザーのid

#### Backlogスペースの管理者またはプロジェクトの管理者の場合

```
/get-user-list.php
```

を実行し、ユーザーリストを取得する。
その後、該当ユーザーの情報からidを取得する
（ちょっとめんどい）

```
array(8) {
    'id' =>
    int(XXXXXXXXX) // ←これがid
    'userId' =>
    string(11) "XXXXXXXXX"
    'name' =>
    string(9) "XXXXXXXXX"
    'roleType' =>
    int(2)
    'lang' =>
    string(2) "ja"
    'mailAddress' =>
    string(19) "XXXXXXXXX"
    'nulabAccount' =>
    array(3) {
      'nulabId' =>
      string(50) "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
      'name' =>
      string(9) "XXXXXXXXX"
      'uniqueId' =>
      string(9) "XXXXXXXXX"
    }
    'keyword' =>
    string(19) "XXXXXXXXX"
}
```

#### Backlogスペースの管理者またはプロジェクトの管理者のではない場合

参考）
https://hacknote.jp/archives/55613/

## 抽出

```
/get-daily-activity.php
```
を実行することで取得できる
（ブラウザとかで実行すると表示するよ）

### 各種設定

```
$userId = XXXXX; # 取得したユーザーのID 
$backlogApiKey = 'XXXXXXXXXXXXXXXXXXXXXXXXXX'; # 取得したAPI Keyを設定
$getCommentCnt = 100;
$getDate = date('Y-m-d'); # 取得する日の設定。当日以外の場合は「Y-m-d」を「2020-01-01」みたいに変更すればその日を取得できます
$getStartDate = '10:30'; # 抽出テキストに作業時間入れたい人は設定、いらなければ削除してください
$getEndDate = '19:30'; # 抽出テキストに作業時間入れたい人は設定、いらなければ削除してください
```

## 抽出結果イメージ

```
実施時間
10:30-19:30

## 実施内容
* NEKO
   * NEKO-1 ねこねこねこねこねこねこねこねこねこねこねこねこねこねこねこ
   * NEKO-12 きゃっときゃっときゃっときゃっときゃっときゃっと
* INU
   * INU-2 いぬいぬいぬいぬいぬいぬいぬ
   * INU-32 どっぐどっぐどっぐどっぐどっぐ
   * INU-35 わんわんわんわん

```