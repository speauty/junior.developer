<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    CsvReader.php
 * Created: 2019/9/2 下午3:47
 */

/**
 * Class CsvReader
 * @package App\Service
 */
class CsvReader
{

    /**
     * to check path is valid or not
     * @param $path
     * @throws \Exception
     */
    private function toCheckFileValidate($path): void
    {
        if (!is_file($path)) {
            throw new \Exception('the file given invalid.');
        }
    }

    /**
     * @param string $path
     * @param array $lineIdx
     * @return array|null
     * @throws \Exception
     */
    public function read(string $path, array $lineIdx):?array
    {
        $return = null;
        $this->toCheckFileValidate($path);
        $file = fopen($path, 'r');
        if ($file && $idxLine = trim(fgets($file))) {
            $idxArr = explode(',', $idxLine);
            $idxLen = count($idxArr);
            unset($idxLine);
            $lineData = [];
            if (count($idxArr) === count($lineIdx)) {
                while(!feof($file)) {
                    $tmpArr = [];
                    /**
                     * checking the line whether empty or not
                     * and the length exploded by , whether equal to length of idxArr
                     * which is the first line of file
                     */
                    if (
                        !($tmpArr = explode(',', trim(fgets($file)))) ||
                        $idxLen !== count($tmpArr)
                    ) {
                        continue;
                    }
                    $lineData[] = array_combine($lineIdx, $tmpArr);
                    unset($tmpArr);
                }
            }
            $return = $lineData;
            unset($idxArr, $idxLen, $lineData);
        }
        fclose($file);
        return $return;
    }

    /**
     * to build a csv file included data
     * @param array $data
     * @param string $dir
     * @param string $fileName
     * @return null|string
     */
    public function build(array $data, string $dir = '', string $fileName = NULL):?string
    {
        /** @var string $dir to reset dir var */
        $dir = $dir?$dir:RUNNING_ROOT.'/Temp/csv/';
        /** to create dir */
        $this->createDir($dir);
        /** @var string $fileName to reset file name */
        $fileName = $fileName?$fileName:$this->buildRandomStr(0, '', true).'.csv';
        $path = $dir.$fileName;
        $encode = '';
        /** @var array $v to build data */
        foreach ($data as &$v) {
            $v = implode(',', $v);
            if (!$encode) {
                $encode = mb_detect_encoding($v, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
            }
            $v = mb_convert_encoding($v, 'GB2312', $encode);
        }
        unset($v);
        file_put_contents($path,implode(PHP_EOL, $data), LOCK_EX);
        unset($dir, $data);
        return $path;
    }

    private function createDir(string $dir):void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 755);
        }
    }

    /**
     * @param int $len
     * @param string $chars
     * @param bool $uuid
     * @return string
     */
    private function buildRandomStr($len = 6, $chars = '', bool $uuid = false)
    {
        $str = '';
        if ($uuid) {
            if (function_exists('com_create_guid') === true) {
                $str = trim(com_create_guid(), '{}');
            } else {
                $str = sprintf( '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
                    mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
                    mt_rand(16384, 20479), mt_rand(32768, 49151),
                    mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)
                );
            }
        } else {
            if (!$chars) {
                $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            }
            for ($i = 0, $str = '', $lc = strlen($chars) - 1; $i < $len; $i++) {
                $str .= $chars[mt_rand(0, $lc)];
            }
        }

        return $str;
    }
}