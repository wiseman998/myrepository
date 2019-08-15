<?php
namespace Home\Controller;
use Think\Controller;
class TixianController extends Controller {
    
	public function index(){
		if($_POST){
			$mid=$_SESSION['mid'];
			//密码
			$pin=$_POST['pin'];
			//类型 分享分红
			$type=$_POST['lx'];
			if($type != 0){
				switch($type)
				{
					case 1:
						//金额
						$cash=$_POST['point'];
						break;
					case 2;
						//金额
						$cash=$_POST['money'];
						break;
				}
				//提现金额不能为空
				if($cash){
					//判断密码
					$mem=M("Member")->field("pin")->where("id=$mid")->find();
					$pin1=$mem['pin'];
					if($pin==$pin1){
						//查询提现记录判断用户第几次提现
						$cashlist=M("Cash")->where("mid=$mid")->select();
						//提现标准 10 或者100
						$setcash="";
						//距上次提现的时间0不允许提现1允许提现
						$setcan=0;
						if($cashlist){
							$setcash=100;
							$checkcount=count($cashlist);
							if($checkcount==1){
								$setcan=1;
							}else{
								$nowtime=time();
								$checkcount1=$checkcount-1;
								$cash_time=$cashlist[$checkcount1]['cash_time'];
								$differtime=$nowtime-$cash_time;
								$days=$differtime/1000*60*60*24;
								if($days>=30){
									$setcash=1;
								}else{
									$setcash=0;
								}
							}
						}else{
							$setcash=10;
							$setcan=1;
						}
						
						//判断是否具有提现条件
						if($cash>=$setcash){
							if($setcan==1){
								$arr=$cash%$setcash;
								if(!$arr){
									$pointlist=M("Point")->where("mid=$mid")->find();
									$point=$pointlist['point'];
									$money=$pointlist['money'];
									//分享收益
									if($type==1){
										if($cash<=$point){
													$systemlist=M("System")->where("id=1")->find();
													$systemfee=$systemlist['fee'];
													$systemfee1=1-$systemlist['fee'];
													$fa=$cash*$systemfee;
													$data['mid']=$mid;
													$data['cash']=$cash*$systemfee1;
													$data['cash_time']=time();
													$data['status']=0;
													$data['type']=0;
													$data['fee']=$fa;
													if(M("Cash")->add($data)){
														M("Point")->where("mid=$mid")->setDec("point",$cash);
														//M("Point")->where("mid=$mid")->setInc("volume",$fa);
														$this->success("提现申请成功");
													}else{
														$this->error("消费记录失败");
													}
										}else{
											$this->error("金额不足");
										}
									}else{//分红
											if($cash<=$money){
													$systemlist=M("System")->where("id=1")->find();
													$systemfee=$systemlist['fee'];
													$systemfee1=1-$systemlist['fee'];
													$fa=$cash*$systemfee;
													$data['mid']=$mid;
													$data['cash']=$cash*$systemfee1;
													$data['cash_time']=time();
													$data['status']=0;
													$data['type']=1;
													$data['fee']=$fa;
													if(M("Cash")->add($data)){
														M("Point")->where("mid=$mid")->setDec("money",$cash);
														//M("Point")->where("mid=$mid")->setInc("volume",$fa);
														$this->success("提现申请成功");
													}else{
														$this->error("消费记录失败");
													}
											}else{
												$this->error("金额不足");
											}
											
									}
								}else{
									$this->error("提现金额必须是标准额整数倍");
								}
							}else{
								$this->error("亲，您上次提现还不满一个月");
							}
						}else{
							$this->error("提现金额不能小于标准金额");
						}
					}else{
						$this->error("密码错误");
					}
				}else{
					$this->error("提现金额不能为空");
				}
			}else{
				$this->error('请选择红包类型');
			}
		}else{
			$mid=$_SESSION['mid'];
			$act=$_GET['act'];
			$cash=M("Cash")->where("mid=$mid")->select();
			$point=M("Point")->where("mid=$mid")->find();
			$this->assign("point",$point);
			$this->assign("cash",$cash);
			$this->assign("act",$act);
			$this->display();	
		}
		
	}
	
	
}