<?php
namespace app\index\controller;

use think\Loader;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return "<a href='".url('test')."'>导出</a>";
    }
    public function excel()
    {
        $path = dirname(__FILE__); //找到当前脚本所在路径
        Loader::import('PHPExcel.PHPExcel'); //手动引入PHPExcel.php
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory'); //引入IOFactory.php 文件里面的PHPExcel_IOFactory这个类
        $PHPExcel = new \PHPExcel(); //实例化
        $iclasslist=db('iclass')->select();
        foreach($iclasslist as $key=> $v){
            $PHPExcel->createSheet();
            $PHPExcel->setactivesheetindex($key);
            $PHPSheet = $PHPExcel->getActiveSheet();
            $PHPSheet->setTitle($v['classname']); //给当前活动sheet设置名称
            $PHPSheet->setCellValue("A1", "编号")
                     ->setCellValue("B1", "姓名")
                     ->setCellValue("C1", "性别")
                     ->setCellValue("D1", "身份证号")
                     ->setCellValue("E1", "宿舍编号")
                     ->setCellValue("F1", "班级");//表格数据
            $userlist=db('users')->where("iclass=".$v['id'])->select();
            //echo db('users')->getLastSql();
            $i=2;
            foreach($userlist as $t)
            {
                $PHPSheet->setCellValue("A".$i, $t['id'])
                         ->setCellValue("B".$i, $t['username'])
                        ->setCellValue("C".$i, $t['sex'])
                        ->setCellValue("D".$i, $t['idcate'])
                        ->setCellValue("E".$i, $t['dorm_id'])
                        ->setCellValue("F".$i, $t['iclass']);
                        //表格数据
                $i++;
            }

        }
       // exit;
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007"); //创建生成的格式
        header('Content-Disposition: attachment;filename="学生列表'.time().'.xlsx"'); //下载下来的表格名
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件
    }
    public function tester()
    {
         $a = 3;
            $b = 5;
            if($a = 5 || $b = 7) {
                ++$a;
                $b++;
            }
            echo $a . " " . $b;
    }
    public function test()
    {
        
        $path = dirname(__FILE__); //找到当前脚本所在路径
        Loader::import('PHPExcel.PHPExcel'); //手动引入PHPExcel.php
        Loader::import('PHPExcel.PHPExcel.IOFactory.PHPExcel_IOFactory'); //引入IOFactory.php 文件里面的PHPExcel_IOFactory这个类
        $PHPExcel = new \PHPExcel(); //实例化
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AB');
        $userbj=db('wx_iclass')->select();
        foreach($userbj as $k=>$use){
//                echo "<pre>";
//                print_r($v);exit;
            $PHPExcel->createSheet();//建sheet
            $PHPExcel->setactivesheetindex($k);
            $phpSheet = $PHPExcel->getActiveSheet();//加标记
            $phpSheet->setTitle($use['classname']);//每个的sheet的名称
            $lists=Db::query('SHOW FULL COLUMNS from wx_users');
//                     echo "<pre>";
//                print_r($lists);exit;
            foreach($lists as $k=>$vn) {//获取当前表结构,赋给sheet的第一行
                $comment=$vn['Comment']?$vn['Comment']:$vn['Field'];
                $phpSheet->setCellValue($cellName[$k].'1',$comment);
            }
            $users=db('wx_users')->where("iclass='".$use['id']."'")->select();
            $i=2;
            foreach($users as $k=>$vs){
                $j=0;
                foreach($vs as $k=>$v){
                    $phpSheet->setCellValue($cellName[$j].$i,$v);
                    $j++;
                }
                $i++;
            }
        }
        $PHPWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, "Excel2007"); //创建生成的格式
        header('Content-Disposition: attachment;filename="student.xlsx"'); //下载下来的表格名
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $PHPWriter->save("php://output"); //表示在$path路径下面生成demo.xlsx文件

    }
    
    
}
