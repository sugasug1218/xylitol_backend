<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IncomplateUserFollowBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:follow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '本登録未完了ユーザーフォローの日次バッチ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        echo random_int(1, 20);

        // 目的：Laravelによるバッチ処理実装
        // 機能名：日次バッチによる本登録フォロー

        // ・日次で本登録が完了していない仮登録ユーザーを抽出
        // ・トークンをリフレッシュして新しいものを発行する
        // ・本登録完了を促すメールを送信する

        // 【変更点】
        // ・PreUserテーブルにトークン期限を管理するカラムを追加する
        // →created_atは使えない（リフレッシュしても期限が延長できない）
        // 　 あくまでレコード更新するなら必要

        // ・PreUserテーブルにフォロー回数のカラムを追加する
        // ・トークン有効期限チェックのロジックをいじる必要がある
    }
}
