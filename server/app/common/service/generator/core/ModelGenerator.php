<?php

declare(strict_types=1);

namespace app\common\service\generator\core;


/**
 * 模型生成器
 * Class ModelGenerator
 * @package app\common\service\generator\core
 */
class ModelGenerator extends BaseGenerator implements GenerateInterface
{

    /**
     * @notes 替换变量
     * @return mixed|void
     * @author bingo
     * @date 2022/6/22 18:16
     */
    public function replaceVariables()
    {
        // 需要替换的变量
        $needReplace = [
            '{NAMESPACE}',
            '{CLASS_COMMENT}',
            '{UPPER_CAMEL_NAME}',
            '{PACKAGE_NAME}',
            '{TABLE_NAME}',
            '{USE}',
            '{DELETE_USE}',
            '{DELETE_TIME}',
            '{RELATION_MODEL}',
            '{TABLE_COLUMNS}',
            '{TABLE_COLUMNS_PROPERTY}',
        ];
        // 等待替换的内容
        $waitReplace = [
            $this->getNameSpaceContent(),
            $this->getClassCommentContent(),
            $this->getUpperCamelName(),
            $this->getPackageNameContent(),
            $this->getTableName(),
            $this->getUseContent(),
            $this->getDeleteUseContent(),
            $this->getDeleteTimeContent(),
            $this->getRelationModel(),
            $this->getTableColumns(),
            $this->getTableColumnsProperty(),
        ];

        $templatePath = $this->getTemplatePath('php/model');

        // 替换内容
        $content = $this->replaceFileData($needReplace, $waitReplace, $templatePath);

        $this->setContent($content);
    }

    /**
     * 获取表字段
     * @return string
     */
    public function getTableColumns(){
        $columnValue = '    //设置字段信息'. PHP_EOL;
        $columnValue .= '    protected $schema = ['. PHP_EOL;
        $pk = $this->getPkContent();
        foreach ($this->tableColumn as $column) {
            $column_comment = $column['column_comment'];
            if ($pk==$column['column_name']){
                $column_comment = "主键 " . $column_comment;
            }
            $columnValue.= '    //'.$column_comment. PHP_EOL;
            $columnValue.= "    '".$column['column_name']."' => '".$column['column_type']. "',". PHP_EOL;
        }
        $columnValue .= '    ];'. PHP_EOL;
        return $columnValue;
    }


    /**
     * 获取表字段
     * @return string
     */
    public function getTableColumnsProperty(){
        $columnValue = '';
        $pk = $this->getPkContent();
        foreach ($this->tableColumn as $column) {
            $column_comment = $column['column_comment'];
            if ($pk==$column['column_name']){
                $column_comment = "主键 " . $column_comment;
            }
            //@property int $id 主键
            $columnValue.= " * @property ".$column['column_type']." $".$column['column_name']. " ".$column_comment. PHP_EOL;
        }
        return $columnValue;
    }

    /**
     * @notes 获取命名空间模板内容
     * @return string
     * @author bingo
     * @date 2022/6/22 18:16
     */
    public function getNameSpaceContent()
    {
        if (!empty($this->classDir)) {
            return "namespace app\\common\\model\\" . $this->classDir . ';';
        }
        return "namespace app\\common\\model;";
    }


    /**
     * @notes 获取类描述
     * @return string
     * @author bingo
     * @date 2022/6/22 18:16
     */
    public function getClassCommentContent()
    {
        if (!empty($this->tableData['table_comment'])) {
            $tpl = $this->tableData['table_comment'] . '模型';
        } else {
            $tpl = $this->getUpperCamelName() . '模型';
        }
        return $tpl;
    }


    /**
     * @notes 获取包名
     * @return string
     * @author bingo
     * @date 2022/6/22 18:16
     */
    public function getPackageNameContent()
    {
        return !empty($this->classDir) ? '\\' . $this->classDir : '';
    }


    /**
     * @notes 引用内容
     * @return string
     * @author bingo
     * @date 2022/12/12 17:32
     */
    public function getUseContent()
    {
        $tpl = "";
        if ($this->deleteConfig['type']) {
            $tpl = "use think\\model\\concern\\SoftDelete;";
        }
        return $tpl;
    }


    /**
     * @notes 软删除引用
     * @return string
     * @author bingo
     * @date 2022/12/12 17:34
     */
    public function getDeleteUseContent()
    {
        $tpl = "";
        if ($this->deleteConfig['type']) {
            $tpl = "use SoftDelete;";
        }
        return $tpl;
    }


    /**
     * @notes 软删除时间字段定义
     * @return string
     * @author bingo
     * @date 2022/12/12 17:38
     */
    public function getDeleteTimeContent()
    {
        $tpl = "";
        if ($this->deleteConfig['type']) {
            $deleteTime = $this->deleteConfig['name'];
            $tpl = 'protected $deleteTime = ' . "'". $deleteTime ."';";
        }
        return $tpl;
    }


    /**
     * @notes 关联模型
     * @return string
     * @author bingo
     * @date 2022/12/14 14:46
     */
    public function getRelationModel()
    {
        $tpl = '';
        if (empty($this->relationConfig)) {
            return $tpl;
        }

        // 遍历关联配置
        foreach ($this->relationConfig as $config) {
            if (empty($config) || empty($config['name']) || empty($config['model'])) {
                continue;
            }

            $needReplace = [
                '{RELATION_NAME}',
                '{AUTHOR}',
                '{DATE}',
                '{RELATION_MODEL}',
                '{FOREIGN_KEY}',
                '{LOCAL_KEY}',
            ];

            $waitReplace = [
                $config['name'],
                $this->getAuthorContent(),
                $this->getNoteDateContent(),
                $config['model'],
                $config['foreign_key'],
                $config['local_key'],
            ];

            $templatePath = $this->getTemplatePath('php/model/' . $config['type']);
            if (!file_exists($templatePath)) {
                continue;
            }
            $tpl .= $this->replaceFileData($needReplace, $waitReplace, $templatePath) . PHP_EOL;
        }

        return $tpl;
    }


    /**
     * @notes 获取文件生成到模块的文件夹路径
     * @return string
     * @author bingo
     * @date 2022/6/22 18:16
     */
    public function getModuleGenerateDir()
    {
        $dir = $this->basePath . 'common/model/';
        if (!empty($this->classDir)) {
            $dir .= $this->classDir . '/';
            $this->checkDir($dir);
        }
        return $dir;
    }


    /**
     * @notes 获取文件生成到runtime的文件夹路径
     * @return string
     * @author bingo
     * @date 2022/6/22 18:17
     */
    public function getRuntimeGenerateDir()
    {
        $dir = $this->generatorDir . 'php/app/common/model/';
        $this->checkDir($dir);
        if (!empty($this->classDir)) {
            $dir .= $this->classDir . '/';
            $this->checkDir($dir);
        }
        return $dir;
    }


    /**
     * @notes 生成的文件名
     * @return string
     * @author bingo
     * @date 2022/6/22 18:17
     */
    public function getGenerateName()
    {
        return $this->getUpperCamelName() . '.php';
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
            'type' => 'php',
            'content' => $this->content
        ];
    }


}