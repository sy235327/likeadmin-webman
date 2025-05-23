<?php

declare(strict_types=1);

namespace app\common\service\generator\core;

use think\helper\Str;

/**
 * vue-api生成器
 * Class VueApiGenerator
 * @package app\common\service\generator\core
 */
class VueApiGenerator extends BaseGenerator implements GenerateInterface
{

    /**
     * @notes 替换变量
     * @return mixed|void
     * @author bingo
     * @date 2022/6/22 18:19
     */
    public function replaceVariables()
    {
        // 需要替换的变量
        $needReplace = [
            '{COMMENT}',
            '{UPPER_CAMEL_NAME}',
            '{ROUTE}'
        ];

        // 等待替换的内容
        $waitReplace = [
            $this->getCommentContent(),
            $this->getUpperCamelName(),
            $this->getRouteContent(),
        ];

        $templatePath = $this->getTemplatePath('vue/api');

        // 替换内容
        $content = $this->replaceFileData($needReplace, $waitReplace, $templatePath);

        $this->setContent($content);
    }


    /**
     * @notes 描述
     * @return mixed
     * @author bingo
     * @date 2022/6/22 18:19
     */
    public function getCommentContent()
    {
        return $this->tableData['table_comment'];
    }


    /**
     * @notes 路由名称
     * @return string
     * @author bingo
     * @date 2022/6/22 18:19
     */
    public function getRouteContent()
    {
        $content = Str::studly($this->getTableName());
        if (!empty($this->classDir)) {
            $content = $this->classDir . '/' . Str::studly($this->getTableName());
        }
        return $content;
    }


    /**
     * @notes 获取文件生成到模块的文件夹路径
     * @return mixed|void
     * @author bingo
     * @date 2022/6/22 18:19
     */
    public function getModuleGenerateDir()
    {
        $admin_url = getenv('GENERATOR.GENERATORURL',false);
        if ($admin_url){
            $dir = $admin_url . '/src/api/';
        }else{
            $dir = dirname(root_path()). '/adminapi/src/api/';
        }
        $this->checkDir($dir);
        return $dir;
    }


    /**
     * @notes 获取文件生成到runtime的文件夹路径
     * @return string
     * @author bingo
     * @date 2022/6/22 18:20
     */
    public function getRuntimeGenerateDir()
    {
        $dir = $this->generatorDir . 'vue/src/api/';
        $this->checkDir($dir);
        return $dir;
    }


    /**
     * @notes 生成的文件名
     * @return string
     * @author bingo
     * @date 2022/6/22 18:20
     */
    public function getGenerateName()
    {
        return $this->getLowerTableName() . '.ts';
    }


    /**
     * @notes 文件信息
     * @return array
     * @author bingo
     * @date 2022/6/23 15:57
     */
    public function fileInfo(): array
    {
        return [
            'name' => $this->getGenerateName(),
            'type' => 'ts',
            'content' => $this->content
        ];
    }


}