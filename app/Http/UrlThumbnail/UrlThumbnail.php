<?php

namespace App\Http\UrlThumbnail;

use Exception;
use DOMDocument;
use DOMXPath;


class UrlThumbnail {

    public function getUrlThumbnail($url)
    {
        //OGPを取得したいURL
        $url = $url;
        // URLの存在を確認
    $headers = @get_headers($url);
    if (!$headers || strpos($headers[0], '404') !== false) {
        // URLが存在しない場合の処理
        // エラーメッセージの設定や適切なデフォルト値の設定など、適宜追加してください
        return [
            'title' => null,
            'image' => null,
            'description' => null,
        ];
    }

        try{
            if($url){
            //Webページの読み込みと文字コード変換
            $html = file_get_contents($url);
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'auto');
            //DOMDocumentとDOMXpathの作成
            $dom = new DOMDocument;
            @$dom->loadHTML($html);
            $xpath = new DOMXPath($dom);
            //XPathでmetaタグのog:titleおよびog:imageを取得
            $node_title = $xpath->query('//meta[@property="og:title"]/@content');
            $node_image = $xpath->query('//meta[@property="og:image"]/@content');
            $node_description = $xpath->query('//meta[@property="og:description"]/@content');
            //変数に代入
            $title = $node_title->item(0)->nodeValue;
            $image = $node_image->item(0)->nodeValue;
            $description = $node_description->item(0)->nodeValue;
            }
        } catch(Exception $e) {
            return [
                'title' => null,
                'image' => null,
                'description' => null,
            ];
        }

        return [
            'title' => $title,
            'image' => $image,
            'description' =>$description,
        ];
    }
}