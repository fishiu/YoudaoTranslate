<?php

/**
 * 生词本功能
 * Class WordBook
 */
class WordBook
{
    /**
     * 生词本添加地址
     */
    const ADD_WORD_URL = 'https://api.frdic.com/api/open/v1/studylist/words';

    /**
     * WordBook constructor.
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
    }

    /**
     * @param string $word 单词
     */
    public function add($word)
    {
        if ($this->pushWord($word)) {
            echo $word . ' 已加入生词本';
        } else {
            echo '添加到生词本失败';
        }
    }

    /**
     * @param $word
     * @return bool
     */
    private function pushWord($word)
    {
        $params = ['language' => 'en', 'id' => '1597925717', 'words' => [$word]];
        $url = self::ADD_WORD_URL;
        $header = $this->buildHeader();
        $fields = json_encode($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
        $output = json_decode(curl_exec($curl), true);
        $msg = substr($output['message'], 0, 18);
        curl_close($curl);
        return $msg == "单词导入成功";
    }

    /**
     * 请求头
     * @return array
     */
    private function buildHeader()
    {
        return [
            'User-Agent:Mozilla/5.0 (Macintosh Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.106 Safari/537.36',
            'Content-Type: application/json',
            'Cache-Control:no-cache',
            'Accept:*/*',
            'Connection:Keep-Alive',
            'Authorization:NIS oLBbLS9QLWxZpdvXBs4ReWHM+Dmi9FgHYOGNAKGpVNA7cvsEidOFrA=='
        ];
    }
}
