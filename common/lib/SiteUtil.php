<?php

namespace common\lib;

use yii;
use common\models\User;
use yii\helpers\Html;
use yii\db\Expression;
use yii\caching;
use yii\caching\DbDependency;
use common\models\Services;
use common\models\ClinicProfile;
use common\models\Timing;
use common\models\ClinicDoctors;
use common\models\DoctorProfile;
use common\models\Qualification;
use common\models\Awards;
use common\models\Membership;
use common\models\Feeds;

class SiteUtil {

public static function UploadS3($fileName, $fileTempName, $bucketname) {
        $s3handle = new \Aws\S3\S3Client(array('credentials' => array(
                'key' => \Yii::$app->params['aws.key'],
                'secret' => \yii::$app->params['aws.secret'],
            ),
            'region' => 'ap-southeast-1',
            'version' => 'latest'
        ));
        $result = $s3handle->putObject([
            'Bucket' => $bucketname,
            'Key' => $fileName,
            'SourceFile' => $fileTempName,
            'ACL' => 'public-read',
            'CacheControl' => 'public, max-age=94608000',
            'ContentType' => self::MIMEType($fileTempName),
            'Expires' => gmdate("D, d M Y H:i:s T", strtotime("+3 years")),
        ]);
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
}

 public static function remoteFileExists($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        $result = curl_exec($curl);

        $ret = false;
        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($statusCode == 200) {
                $ret = true;
            }
        }
        curl_close($curl);

        return $ret;
    }

    public static function MIMEType(&$file) {
        static $exts = array(
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif',
            'png' => 'image/png', 'ico' => 'image/x-icon', 'pdf' => 'application/pdf',
            'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml', 'swf' => 'application/x-shockwave-flash',
            'zip' => 'application/zip', 'gz' => 'application/x-gzip',
            'tar' => 'application/x-tar', 'bz' => 'application/x-bzip',
            'bz2' => 'application/x-bzip2', 'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload', 'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed', 'txt' => 'text/plain',
            'asc' => 'text/plain', 'htm' => 'text/html', 'html' => 'text/html',
            'css' => 'text/css', 'js' => 'text/javascript',
            'xml' => 'text/xml', 'xsl' => 'application/xsl+xml',
            'ogg' => 'application/ogg', 'mp3' => 'audio/mpeg', 'wav' => 'audio/x-wav',
            'avi' => 'video/x-msvideo', 'mpg' => 'video/mpeg', 'mpeg' => 'video/mpeg',
            'mov' => 'video/quicktime', 'flv' => 'video/x-flv', 'php' => 'text/x-php'
        );

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (isset($exts[$ext]))
            return $exts[$ext];

        // Use fileinfo if available
        if (extension_loaded('fileinfo') && isset($_ENV['MAGIC']) &&
                ($finfo = finfo_open(FILEINFO_MIME, $_ENV['MAGIC'])) !== false) {
            if (($type = finfo_file($finfo, $file)) !== false) {
                // Remove the charset and grab the last content-type
                $type = explode(' ', str_replace('; charset=', ';charset=', $type));
                $type = array_pop($type);
                $type = explode(';', $type);
                $type = trim(array_shift($type));
            }
            finfo_close($finfo);
            if ($type !== false && strlen($type) > 0)
                return $type;
        }

        return 'application/octet-stream';
    }
    
    public static function PacBlogPic($id, $type, $api = null) {
        if ($type == 1) {
            $pac = \common\models\Packages::find()->where(['id' => $id])->one();
            if (!empty($pac->preview_img)) {
                if ($api) {
                    return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/package/' . $pac->preview_img;
                } else {
                    return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/package/' . $pac->preview_img;
                }
            } else {
                return Yii::$app->request->hostInfo . '/images/package/default_image.png';
            }
        } else if ($type == 3) {
            $blog = \common\models\Blog::find()->where(['id' => $id])->one();
            if (!empty($blog->authorr->author_pic)) {
                return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $blog->authorr->author_pic;
            } else {
                return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
            }
        } else if ($type == 2) {
            $blog = \common\models\Blog::find()->where(['id' => $id])->one();
            if (!empty($blog->banner_image)) {
                return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/blogs/' . $blog->banner_image;
            } else {
                return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
            }
        } else if ($type == 4) {
            $eve = \common\models\NirogEvents::find()->where(['id' => $id])->one();
            if (!empty($eve->file_upload)) {
                return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/events/' . $eve->file_upload;
            } else {
                return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
            }
        } else if ($type == 5) {
            $des = \common\models\DiseaseDetail::find()->where(['id' => $id])->one();
            if (!empty($des->img)) {
                return 'https://s3-' . yii::$app->params['s3.region'] . '.amazonaws.com/' . yii::$app->params['s3.bucketname'] . '/images/knowledge/' . $des->img;
            } else {
                return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
            }
        } else {
            return Yii::$app->request->hostInfo . '/images/blogs/default_image.png';
        }
    }
}
