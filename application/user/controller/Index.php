<?php
namespace app\user\controller;

use think\Loader;
use think\controller;

class Index extends Controller
{
    public function index()
    {
        $path = dirname(__FILE__); //找到当前脚本所在路径
        Loader::import('PHPExcel.PHPExcel'); //手动引入PHPExcel.php
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory'); //引入IOFactory.php 文件里面的PHPExcel_IOFactory这个类
        $PHPExcel = new \PHPExcel(); //实例化
        //$iclasslist=db('iclass')->select();
        //foreach($iclasslist as $key=> $v){
            $PHPExcel->createSheet();
            $PHPExcel->setactivesheetindex(0);
            $PHPSheet = $PHPExcel->getActiveSheet();
            $PHPSheet->setTitle('16php'); //给当前活动sheet设置名称
            $PHPSheet->setCellValue("A1", "编号")
                     ->setCellValue("B1", "姓名")
                     ->setCellValue("C1", "性别")
                     ->setCellValue("D1", "身份证号")
                     ->setCellValue("E1", "宿舍编号")
                     ->setCellValue("F1", "班级");//表格数据
            //$userlist=db('users')->where("iclass=".$v['id'])->select();
            //echo db('users')->getLastSql();
            //$i=2;
            // foreach($userlist as $t)
            // {
                $PHPSheet->setCellValue("A2", '赞赞1')
                         ->setCellValue("B2", '赞赞2')
                         ->setCellValue("C2",'赞赞3' )
                         ->setCellValue("D2", '赞赞4')
                         ->setCellValue("E2", '赞赞5')
                         ->setCellValue("F2",'赞赞6' );
                        //表格数据
                // $i++;
            //}

        //}
       // exit;
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007"); //创建生成的格式
        header('Content-Disposition: attachment;filename="学生列表'.time().'.xlsx"'); //下载下来的表格名
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
    
}


?>