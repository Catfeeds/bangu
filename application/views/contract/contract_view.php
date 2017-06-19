<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <title>移动端_合同页面</title>
    </head>
    <style>
    html,body{ height: 100%;}
    body{ margin: 0; padding: 0; font-size: 13px;font-family:"Microsoft YaHei",微软雅黑,"Microsoft JhengHei",华文细黑,STHeiti,MingLiu}
    ul,li{list-style-type: none;}
    i{font-style: normal;}
    a{ text-decoration: none; color: #333;}
    input{font-family:"Microsoft YaHei",微软雅黑,"Microsoft JhengHei",华文细黑,STHeiti,MingLiu}

    ::-webkit-input-placeholder {color: #285FFF;}
    :-moz-placeholder {color: #285FFF;}
    ::-moz-placeholder {color: #285FFF;}
    :-ms-input-placeholder {color: #285FFF;}

    .sortableContent{ padding: 50px 15px;}

    /* 合同样式  begin*/
    .preHetong{ line-height: 30px;}
    .preHetong span{ display: inline-block;}
    .pre_title{ text-align: center; font-size: 24px;}
    .pre_BanTop{ padding: 0 15px; text-align: right;}
    .pre_bottom{ border-bottom: 1px solid #222; padding: 0 10px;}
    .pre_RedColor{ color: #f30; font-size: 20px;}
    .pre_Text{}
	.pre_Text span{ line-height: 20px !important;}
    .pre_H40{ padding: 20px 0;}
    .pre_H20{ padding: 10px 0;}
	.pre_T200{ width: 200px; display: inline-block;}
    .pre_T100{ width: 100px;display: inline-block;}
    .pre_T50{ width: 50px;display: inline-block;}
    .pre_T20{ width:20px;display: inline-block;}
    .pre_T20w{ width: 20px;}
    .pre_T30{ width: 30px;display: inline-block;}
    .pre_T40{ width: 40px;display: inline-block;}

    .pre_fl{float: left; text-indent: 0;height: 30px;line-height: 45px;}

    .pre_W50{width: 50px; display: initial;}
    .pre_W100{width: 100px; display: initial;}

    .pre_winf{ font-weight: bold;}
    /*.pre_indent{ text-indent: 2em;}*/
    .pre_leftPadd{ padding-left: 64px; height: 38px;}
    .pre_Item{ float: left; text-indent: 0;}

    .pre_block_border{ width: 100%; border-bottom: 1px solid #222; height: 30px; line-height: 45px;}
    .pre_Ado{ width: 100%; position: relative; float: left;}
    .pre_Ado_title{ text-indent: 2em; position: absolute;bottom: -1px;: 0;left: 0; background: #fff; height: 30px;line-height: 30px;}
    .pre_over{ overflow: hidden;}
	.pre_Ado .jquery_padding{ position:relative; top:2px;}

    .inputNone{border: none;border-bottom: 1px solid #000;outline: none;}
    .indentNone{ text-indent: 0;}
    .qm_input{ outline: none; border:none; border:0; border-bottom: 1px solid #000; background: none;}
    /* 合同样式  end*/

    .ableHover{ background: #f9f9f9 !important;}
    .paddinFang{ border: 2px dashed #285FFF; background: #CDD9FF; padding: 15px 0;}
    .hetong.jiafang{ padding-bottom: 20px;}
    .hetong .charGong , .hetong .charQian , .hetong .charTime {font-size: 14px; height: 30px; line-height: 30px; padding: 0 20px;position: relative;margin: 8px 0;}
    .overHidden{ overflow: hidden;}
    .sortableSign{ padding: 0 20px 50px 20px;}

    .pre_block_border_lh{ line-height: 30px;}
    .backNone{ background: #CDD9FF;}
    .backOption{bottom:-3px; padding-right: 10px;}
    .borBlock_None{ border: none;  display: block;}

	.underline{height: auto;text-decoration: underline;border: none;}
	
	.user-sign{position: relative;}
	.user-sign-img.Imhg{position: absolute; left:94px; top:72px;}
	.user-sign-img.Imhg .signImhg{ height:51px; display:block;}
	
	.user-sign-img.sinUerio{position: absolute; left:30%; top:0px;height: 100px;}
	.user-sign-img.sinUerio img{height:100%;}
	.user-sign-img.sinUerio .UerioImg{ height:76px; display:block;}
	
	/* 签字弹层*/
	#sign-box{position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;background: #fff;display:none;}
	#sign-box .sign-content{height: 35%;margin-top: 5%;border: 1px solid #666;margin: 5px;}
	#sign-box .sign-buts {text-align: center;height: 15%;margin-top: 5%;}
	#sign-box .sign-buts button {border: 1px solid #ccc;padding: 3px 10px;border-radius: 3px;background:rgb(62, 175, 224);color: #fff;}
	.pre_Text{ line-height:30px;}
	.chapter-box{position: relative;}
	.chapter-box .chapter-img{position: absolute;top: 25%;width: 50%;height: 60%;left: 30%;}
	.chapter-box .chapter-img img{max-width: 100%;max-height: 100%;}
	.flex{ display:flex}
	.filix{ width:40px; line-height:30px !important; height:30px;}
	.flex1{flex:1; height:auto !important;}
	.flexFl{ float:left;}
	
	.padding-bottom{ margin-bottom:20px;}
	.pre_Ado .jquery_padding.underlineH{ line-height:30px !important;}
	.text-poer{ position: relative;}
	.text-poer .poerImg {position: absolute; top:0px; right:5%; height:100px;}
	.text-poer .poerImg2 {position: absolute; top:0px; right:36%; height:100px;}
	.click-sign{position: absolute;left: 106px;top: 36px;color: #ccc;font-size: 15px;}
    </style>
    <body>

    <div class="scrollBar">
        <div class="scrollAuto">
            <div id="sortable">
                <div class="itomgs">
                    <div class="sortableContent preHetong">
                        <div class="pre_title">境内旅游合同</div>
                        <div class="pre_BanTop">合同编号：<span class="pre_bottom pre_RedColor"><?php echo $detailArr['contract_code'];?></span></div>
                        <div class="pre_Text flex"><span class="flex1">旅游者：<span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['travelman'];?></span>等 <span class=" inputNone pre_bottom pre_T20"><?php echo $detailArr['travelnum'];?></span>人（名单可附页）;</span></div>
                        <div class="pre_H20"></div>
                        <div class="pre_Text flex">旅行社：<span class="flex1"><span class=" inputNone pre_bottom pre_T200"><?php echo $detailArr['travel_agency'];?></span>;</span></div>
                        <div class="pre_Text">经营许可证编号<span class=" inputNone pre_bottom pre_T100"><?php echo $detailArr['business_code'];?></span>;</div>
                        <div class="pre_H20"></div>
                        <div class="pre_Text">帮游网：<span class="inputNone pre_bottom pre_T100"><?php echo $detailArr['business_code'];?></span>;</div>
                        
                        <div class="pre_H40"></div>

                        <div class="pre_Text pre_indent pre_winf">第一条<span class="pre_T20"></span>本合同术语和定义</div>
                        <div class="pre_Text pre_indent ">1.自由活动，特指《旅游行程单》中安排的自由活动。</div>
                        <div class="pre_Text pre_indent ">2.自行安排活动期间，指《旅游行程单》中安排的自由活动期间、旅游者不参加旅游行程活动期间、每日行程开始前、结束后旅游者离开住宿设施的个人活动期间、旅游者经导游同意暂时离团的个人活动期间。</div>
                        <div class="pre_Text pre_indent ">3.具体购物场所，指购物场所有独立的商号以及相对清晰、封闭、独立的经营边界和明确的经营主体。</div>
                        <div class="pre_Text pre_indent ">4.不可抗力，指不能预见、不能避免并不能克服的客观情况，包括但不限于因自然原因和社会原因引起的，如自然灾害、战争、恐怖活动、动乱、骚乱、罢工、突发公共卫生事件、政府行为。</div>
                        <div class="pre_Text pre_indent ">5.已尽合理注意义务仍不能避免的事件，指因当事人故意或者过失以外的客观因素引发的事件，包括但不限于交通堵塞，飞机、火车、班轮、城际客运班车等公共客运交通工具延误或者取消，景点临时不开放。</div>
                        <div class="pre_Text pre_indent ">6.必要的费用，指旅行社履行合同已经发生或者必然发生的费用以及向地接社或者履行辅助人支付且不可退还的费用, 包括乘坐飞机（车、船）等交通工具的费用（含预订金）、饭店住宿费用（含预订金）、旅游观光汽车的人均车租、导游费用的人均分担、地接综合服务费等。</div>
                        <div class="pre_Text pre_indent ">7.公共交通经营者，指航空、铁路、航运客轮、城市公交、地铁、出租车等公共交通工具经营者。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第二条<span class="pre_T20"></span>双方的权利义务</div>
                        <div class="pre_Text pre_indent ">（一）旅游者的权利与义务</div>
                        <div class="pre_Text pre_indent ">1.有权知悉其购买的旅游产品和服务的真实情况，有权要求旅行社按照约定提供产品和服务，拒绝旅行社未经协商一致指定具体购物场所，安排另行付费旅游项目的行为。</div>
                        <div class="pre_Text pre_indent ">2.有权拒绝旅行社未经事先协商一致的转团、拼团行为。</div>
                        <div class="pre_Text pre_indent ">3.应当如实告知与旅游活动相关的个人健康信息，并对其真实性负责；参加适合自身条件的旅游活动，遵守旅游活动中的安全警示要求，配合有关部门、机构或旅行社采取的安全防范和应急处理措施。</div>
                        <div class="pre_Text pre_indent ">4.在签订合同或者填写各种材料时，应当使用有效身份证件，并对填写信息的真实性、有效性负责，保证所提供的联系方式准确无误且能及时联系。</div>
                        <div class="pre_Text pre_indent ">5.按照合同约定随团完成旅游行程，配合导游人员的统一管理；遵守法律、法规和有关规定，不参与色情、赌博和涉毒活动；不得擅自分团、脱团。</div>
                        <div class="pre_Text pre_indent ">6.遵守旅游目的地的公共秩序和社会公德，尊重当地的风俗习惯，文化传统和宗教信仰，爱护旅游资源，保护生态环境，遵守《中国公民国内旅游文明行为公约》等文明行为规范。</div>
                        <div class="pre_Text pre_indent ">7. 妥善保管自己的行李物品，随身携带现金、有价证券、贵重物品，不在行李中夹带。</div>
                        <div class="pre_Text pre_indent ">8.在旅游活动中或者在解决纠纷时，应采取适当措施防止损失扩大，不损害当地居民的合法权益，不干扰他人的旅游活动，不损害旅游经营者和旅游从业人员的合法权益，不采取拒绝上、下机（车、船）、拖延行程或者脱团等不当行为。</div>
                        <div class="pre_Text pre_indent ">9.在自行安排活动期间，应当在自己能够控制风险的范围内选择活动项目，遵守旅游活动中的安全警示规定，并对自己的安全负责。</div>

                        <div class="pre_Text pre_indent ">（二）旅行社的权利与义务</div>
                        <div class="pre_Text pre_indent ">1.按照合同和《旅游行程单》约定的内容和标准为旅游者提供服务，不擅自变更旅游行程安排，不降低服务标准；</div>
                        <div class="pre_Text pre_indent ">2.要求旅游者对在旅游活动中或者在解决纠纷时损害旅行社合法权益的行为承担赔偿责任；</div>
                        <div class="pre_Text pre_indent ">3.在合同订立时及履行中，旅行社应对旅游中可能危及旅游者人身、财产安全的情况，作出真实说明和明确警示，并采取防止危害发生的适当措施（可在行程单中提示，由旅游者确认签字）。</div>
                        <div class="pre_Text pre_indent ">4.妥善保管旅游者交其代管的证件、行李等物品；依法对旅游者信息保密。</div>
                        <div class="pre_Text pre_indent ">5.为旅游者安排符合法律法规规定的导游人员。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第三条<span class="pre_T20"></span>合同的变更</div>
                        <div class="pre_Text pre_indent ">1.旅行社与旅游者双方协商一致，可以变更本合同约定的内容，但应当以书面形式由双方签字确认。由此增加的旅游费用及给对方造成的损失，由变更提出方承担；由此减少的旅游费用，旅行社应当退还旅游者。</div>
                        <div class="pre_Text pre_indent ">2.行程开始前遇到不可抗力或者旅行社、履行辅助人已尽合理注意义务仍不能避免的事件的，双方经协商可以取消行程或者延期出行。取消行程的，按照本合同第七条处理；延期出行的，增加的费用由旅游者承担，减少的费用退还旅游者。</div>
                        <div class="pre_Text pre_indent ">3.行程中遇到不可抗力或者旅行社、履行辅助人已尽合理注意义务仍不能避免的事件，影响旅游行程的，按以下方式处理：</div>
                        <div class="pre_Text pre_indent ">（1）合同不能完全履行的，旅行社经向旅游者作出说明，旅游者同意变更的，可以在合理范围内变更合同，因此增加的费用由旅游者承担，减少的费用退还旅游者。</div>
                        <div class="pre_Text pre_indent ">（2）危及旅游者人身、财产安全的，旅行社应当采取相应的安全措施，因此支出的费用，由旅行社与旅游者分担。</div>
                        <div class="pre_Text pre_indent ">（3）造成旅游者滞留的，旅行社应采取相应的安置措施。因此增加的食宿费用由旅游者承担，增加的返程费用双方分担。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第四条<span class="pre_T20"></span>合同的转让</div>
                        <div class="pre_Text pre_indent ">旅游行程开始前，旅游者可以将本合同中自身的权利义务转让给第三人，旅行社没有正当理由的不得拒绝，并办理相关转让手续，因此增加的费用由旅游者和第三人承担。</div>
                        <div class="pre_Text pre_indent ">正当理由包括但不限于：对应原报名者办理的相关服务不可转让给第三人的；无法为第三人安排交通等情形的；旅游活动对于旅游者的身份、资格等有特殊要求的。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第五条<span class="pre_T20"></span>旅行社解除合同</div>
                        <div class="pre_Text pre_indent ">1.旅行社在行程开始前7日（按照出发日减去解除合同通知到达日的自然日之差计算，下同）以上（含第7日，下同）提出解除合同的，不承担违约责任，旅行社向旅游者退还已收取的全部旅游费用；旅行社在行程开始前7日以内（不含第7日，下同）提出解除合同的，除向旅游者退还已收取的全部旅游费用外，还应当按照本合同第十条（一）第1款的约定承担相应的违约责任。</div>
                        <div class="pre_Text pre_indent ">2.旅游者有下列情形之一的，旅行社可以解除合同（相关法律、行政法规另有规定的除外）：</div>
                        <div class="pre_Text pre_indent ">（1）患有传染病等疾病，可能危害其他旅游者健康和安全的；</div>
                        <div class="pre_Text pre_indent ">（2）携带危害公共安全的物品且不同意交有关部门处理的；</div>
                        <div class="pre_Text pre_indent ">（3）从事违法或者违反社会公德的活动的；</div>
                        <div class="pre_Text pre_indent ">（4）从事严重影响其他旅游者权益的活动，且不听劝阻、不能制止的；</div>
                        <div class="pre_Text pre_indent ">（5）法律规定的影响合同履行的其他情形。</div>
                        <div class="pre_Text ">旅行社因上述情形解除合同的，应当以书面等形式通知旅游者，按照本合同第八条的相关约定扣除必要的费用后，将余款退还旅游者。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第六条<span class="pre_T20"></span>旅游者解除合同</div>
                        <div class="pre_Text pre_indent ">1.未达到约定的成团人数不能成团时，旅游者既不同意转团，也不同意延期出行或者改签其他线路出团的，旅行社应及时发出不能成团的书面通知，旅游者可以解除合同。旅游者在行程开始前7日以上收到旅行社不能成团通知的，旅行社不承担违约责任，向旅游者退还已收取的全部旅游费用；旅游者在行程开始前7日以内收到旅行社不能成团通知的，按照本合同第十条（一）第1款相关约定处理。</div>
                        <div class="pre_Text pre_indent ">2.除本条第1款约定外，在行程结束前，旅游者亦可以书面等形式解除合同（相关法律、行政法规另有规定的除外）。旅游者在行程开始前7日以上提出解除合同的，旅行社应当向旅游者退还全部旅游费用；已向地接社或者履行辅助人支付且不可退还的费用的，应当扣除已向地接社或者履行辅助人支付且不可退还的费用；旅游者在行程开始前7日以内提出解除合同的，旅行社按照本合同第八条相关约定扣除必要的费用后，将余款退还旅游者。</div>
                        <div class="pre_Text pre_indent ">3.旅游者行程前逾期支付旅游费用超过2日的，或者旅游者未按约定时间到达约定集合出发地点，也未能在出发中途加入旅游团队的，视为旅游者解除合同，按照本合同第八条相关约定处理。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第七条<span class="pre_T20"></span>旅游者解除合同</div>
                        <div class="pre_Text pre_indent ">因不可抗力或者旅行社、履行辅助人已尽合理注意义务仍不能避免的事件，影响旅游行程，合同不能继续履行的，旅行社和旅游者均可以解除合同；合同不能完全履行，旅游者不同意变更的，可以解除合同。</div>
                        <div class="pre_Text ">合同解除的，旅行社应当在扣除已向地接社或者履行辅助人支付且不可退还的费用后，将余款退还旅游者。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第八条<span class="pre_T20"></span>必要的费用扣除</div>
                        <div class="pre_Text pre_indent ">1.旅游者在行程开始前7日以内提出解除合同或者按照本合同第五条第2款约定由旅行社在行程开始前解除合同的，按下列标准扣除必要的费用：</div>
                        <div class="pre_Text ">行程开始前6日至4日，按旅游费用总额的20%；</div>
                        <div class="pre_Text ">行程开始前3日至1日，按旅游费用总额的40%；</div>
                        <div class="pre_Text ">行程开始当日，按旅游费用总额的60%。</div>
                        <div class="pre_Text pre_indent ">2.在行程中解除合同的，必要的费用扣除标准为：</div>
                        <div class="pre_Text pre_indent ">60%旅游费用+（40%旅游费用÷旅游天数×已经出游的天数）。</div>
                        <div class="pre_Text pre_indent ">如按上述第1款或者第2款约定比例扣除的必要的费用低于实际发生的费用，旅游者按照实际发生的费用支付，但最高额不应当超过旅游费用总额。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第九条<span class="pre_T20"></span>旅行社协助旅游者返程及费用承担</div>
                        <div class="pre_Text pre_indent ">旅游行程中解除合同的，旅行社应协助旅游者返回出发地或者旅游者指定的合理地点。因旅行社或者履行辅助人的原因导致合同解除的，返程费用由旅行社承担；行程中按照本合同第五条第2款，第六条第2款约定解除合同的，返程费用由旅游者承担；按照本合同第七条约定解除合同的，返程费用由双方分担。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十条<span class="pre_T20"></span>违约责任</div>
                        <div class="pre_Text pre_indent ">（一） 旅行社的违约责任</div>
                        <div class="pre_Text pre_indent ">1.旅行社在行程开始前7日以内提出解除合同的，或者旅游者在行程开始前7日以内收到旅行社不能成团通知，不同意转团、延期出行和改签线路解除合同的，旅行社向旅游者退还已收取的全部旅游费用，并按下列标准向旅游者支付违约金：</div>
                        <div class="pre_Text pre_indent ">行程开始前6日至4日，支付旅游费用总额10%的违约金；</div>
                        <div class="pre_Text pre_indent ">行程开始前3日至1日，支付旅游费用总额15%的违约金；</div>
                        <div class="pre_Text pre_indent ">行程开始当日，支付旅游费用总额20%的违约金。</div>
                        <div class="pre_Text pre_indent ">2.旅行社未按合同约定提供服务，或者未经旅游者同意调整旅游行程（本合同第三条第3款规定的情形除外），造成项目减少、旅游时间缩短或者标准降低的，应当依法承担继续履行、采取补救措施或者赔偿损失等违约责任。</div>
                        <div class="pre_Text pre_indent ">3.旅行社具备履行条件，经旅游者要求仍拒绝履行本合同义务的，旅游者采取订同等级别的住宿、用餐、交通等补救措施的，费用由旅行社承担；造成旅游者人身损害、滞留等严重后果的，旅游者还可以要求旅行社支付旅游费用一倍的赔偿金。</div>
                        <div class="pre_Text pre_indent ">4.未经旅游者同意，旅行社转团、拼团的，旅行社应向旅游者支付旅游费用总额25%的违约金；旅游者解除合同的，旅行社还应向未随团出行的旅游者退还全部旅游费用，向已随团出行的旅游者退还尚未发生的旅游费用。</div>
                        <div class="pre_Text pre_indent ">（二） 旅游者的违约责任</div>
                        <div class="pre_Text pre_indent ">1.因不听从旅行社及其领队的劝告、提示而影响团队行程，给旅行社造成损失的，应当承担相应的赔偿责任。</div>
                        <div class="pre_Text pre_indent ">2.旅游者超出本合同约定的内容进行个人活动所造成的损失，由其自行承担。</div>
                        <div class="pre_Text pre_indent ">3.由于旅游者的过错，使旅行社、履行辅助人、旅游从业人员或者其他旅游者遭受损害的，应当由旅游者赔偿损失。</div>
                        <div class="pre_Text pre_indent ">4.旅游者在旅游活动中或者在解决纠纷时，应采取措施防止损失扩大，否则应当就扩大的损失承担相应的责任。</div>
                        <div class="pre_Text pre_indent ">5.旅游者违反安全警示规定，或者对国家应对重大突发事件暂时限制旅游活动的措施、安全防范和应急处置措施不予配合，造成旅行社损失的，应当依法承担相应责任。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十一条<span class="pre_T20"></span>其他责任</div>
                        <div class="pre_Text pre_indent ">1.因旅游者提供材料存在问题或者自身其他原因导致无法出行，相关责任和费用由旅游者承担，旅行社将未发生的费用退还旅游者。如给旅行社造成损失的，旅游者还应当承担赔偿责任。</div>
                        <div class="pre_Text pre_indent ">2.由于旅游者自身原因导致本合同不能履行或者不能按照约定履行，或者造成旅游者人身损害、财产损失的，旅行社不承担责任。</div>
                        <div class="pre_Text pre_indent ">3.旅游者自行安排活动期间人身、财产权益受到损害的，旅行社在事前已尽到必要警示说明义务且事后已尽到必要救助义务的，旅行社不承担赔偿责任。</div>
                        <div class="pre_Text pre_indent ">4.由于第三方侵害等不可归责于旅行社的原因导致旅游者人身、财产权益受到损害的，旅行社不承担赔偿责任。但因旅行社不履行协助义务致使旅游者人身、财产权益损失扩大的，应当就扩大的损失承担赔偿责任。</div>
                        <div class="pre_Text pre_indent ">5.由于公共交通经营者的原因造成旅游者人身损害、财产损失依法应承担责任的，旅行社应当协助旅游者向公共交通经营者索赔。</div>

                        <div class="pre_H20"></div>
						<div><img src="<?php echo base_url('static/img/tiop.png'); ?>"></div>
                        <div class="pre_Text pre_indent pre_winf">第十二条<span class="pre_T20"></span>线路行程时间</div>
                        <div class="pre_Text pre_indent ">出发时间<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['start_year'];?></span>年<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['start_month'];?></span>月<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['start_day'];?></span>日<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['start_time'];?></span>时，
                        	结束时间<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['end_year'];?></span>年<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['end_month'];?></span>月<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['end_day'];?></span>日<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['end_time'];?></span>时；共<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['days'];?></span>天，饭店住宿<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['nights'];?></span>夜。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十三条<span class="pre_T20"></span>旅游费用及支付（以人民币为计算单位）</div>
                        <div class="pre_Text pre_indent ">成人<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['adultprice'];?></span>元/人，儿童（不满12岁）<span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['childprice'];?></span>元/人；其中，导游服务费 <span class=" inputNone pre_bottom pre_T40"><?php echo $detailArr['serverprice'];?></span>元/人；</div>
                        <div class="pre_Text pre_indent ">旅游费用合计：<span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['total_travel'];?></span>元。</div>
                        <div class="pre_Text pre_indent ">旅游费用支付方式：<span class=" inputNone pre_bottom pre_T100"><?php echo $detailArr['pay_way'];?></span></div>
                        <div class="pre_Text pre_indent ">旅游费用支付时间：<span class=" inputNone pre_bottom pre_T100"><?php echo $detailArr['pay_time'];?></span></div>
                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十四条<span class="pre_T20"></span>人身意外伤害保险</div>
                        <div class="pre_Text pre_indent ">1.旅行社提示旅游者购买人身意外伤害保险；</div>
                        <div class="pre_Text pre_indent ">2.旅游者可以做以下选择：</div>
                        <div class="pre_Text pre_indent "><input type="checkbox" name="checkbox" disabled="disabled" <?php if ($detailArr['is_buy'] ==1) {echo 'checked="checked"';}?> class="checkReact">委托旅行社购买：保险产品名称<input type="text" readonly value="<?php echo $detailArr['insurance_name'];?>" class=" inputNone pre_bottom pre_T100">（投保的相关信息以实际保单为准）；</div>
                        <div class="pre_Text pre_indent "><input type="checkbox" name="checkbox" disabled="disabled" <?php if ($detailArr['is_buy'] ==2) {echo 'checked="checked"';}?> class="checkReact">自行购买</div>
                        <div class="pre_Text pre_indent "><input type="checkbox" name="checkbox" disabled="disabled" <?php if ($detailArr['is_buy'] ==3) {echo 'checked="checked"';}?> class="checkReact">放弃购买。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十五条<span class="pre_T20"></span>成团人数与不成团的约定</div>
                        <div class="pre_Text pre_indent ">成团的最低人数：<span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['min_num'];?></span>人。</div>
                        <div class="pre_Text pre_indent ">如不能成团，旅游者是否同意按下列方式解决：</div>
                        <div class="pre_Text pre_indent ">1.
                        <span class="inputNone pre_bottom pre_T50"><?php echo $detailArr['is_agree_contract'];?></span>（同意或者不同意，打勾无效）旅行社委托旅行社履行合同;</div>
                        
                        <div class="pre_Text pre_indent ">2.
                        <span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['is_agree_delay'];?></span>（同意或者不同意，打勾无效）延期出团；</div>
                        <div class="pre_Text pre_indent ">3.
                        <span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['is_agree_change'];?></span>（同意或者不同意，打勾无效）改签其他线路出团；</div>
                        <div class="pre_Text pre_indent ">4.
                        <span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['is_agree_relieve'];?></span>（同意或者不同意，打勾无效）解除合同。</div>
                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十六条<span class="pre_T20"></span>拼团约定</div>
                        <div class="pre_Text pre_indent ">旅游者<span class=" inputNone pre_bottom pre_T50"><?php echo $detailArr['is_agree_group'];?></span>（同意或者不同意，打勾无效）采用拼团方式拼至<span class=" inputNone pre_bottom pre_T100"><?php echo $detailArr['group_travel'];?></span>旅行社成团。</div>
                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十七条<span class="pre_T20"></span>自愿购物和参加另行付费旅游项目约定</div>
                        <div class="pre_Text pre_indent ">1. 旅游者可以自主决定是否参加旅行社安排的购物活动、另行付费旅游项目；</div>
                        <div class="pre_Text pre_indent ">2. 购物活动、另行付费旅游项目具体约定见《自愿购物活动补充协议》（附件3）、《自愿参加另行付费旅游项目补充协议》（附件4）。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十八条<span class="pre_T20"></span>争议的解决方式</div>
                        <div class="pre_Text pre_indent ">本合同履行过程中发生争议，由双方协商解决，亦可向旅行社所在地的旅游质监执法机构、消费者协会、有关的调解组织等有关部门或者机构申请调解。协商或者调解不成的，双方均可向旅行社住所地人民法院起诉。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第十九条<span class="pre_T20"></span>其他约定事项</div>
                        <div class="pre_Text pre_indent ">未尽事宜，经旅游者和旅行社双方协商一致，可以列入补充条款。（如合同空间不够，可以另附纸张，由双方签字或者盖章确认。）</div>
                        <div class="pre_Text pre_block_border underline">
<!--                             <input type="text" readonly="readonly" value="" class=" inputNone pre_block_border "> -->
                        	<?php echo $detailArr['other_matter'];?>
                        </div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第二十条<span class="pre_T20"></span>订立合同</div>
                        <div class="pre_Text pre_indent ">1.旅行社提供《旅游行程单》应与本合同团号一致，经双方签字或者盖章确认后作为本合同的组成部分。</div>
                        <div class="pre_Text pre_indent ">2.旅游者应当认真阅读本合同条款和《行程单》，在旅游者理解本合同条款及有关附件后，旅行社和旅游者应当签订书面合同。</div>

                        <div class="pre_H20"></div>

                        <div class="pre_Text pre_indent pre_winf">第二十一条<span class="pre_T20"></span>合同效力</div>
                        <div class="pre_Text pre_indent ">本合同一式
                        <span class=" inputNone pre_bottom pre_T30"><?php echo $detailArr['copie'];?></span>份，双方各持<span class=" inputNone pre_bottom pre_T30"><?php echo $detailArr['mutual_copie'];?></span>份，具有同等法律效力，自双方当事人签字盖章或电子确认之日起生效。</div>
                        <div class="pre_H40"></div>
                        <div class="pre_Text indentNone pre_over padding-bottom" id="user-sign" style="position: relative;">
                            <div class="pre_Ado">
                            	<span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">旅游者代表签字：</div>
                            </div>
                            <div class="pre_Ado">
                                <span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">签约代表签字：</div>
                            </div>
                            <div class="pre_Ado">
                                <span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">证件号码：</div>
                            </div>
                            <div class="click-sign">请点击此处签字</div>
                            <div id="user-sign-img" class="user-sign-img sinUerio">
                            	<?php if (!empty($fileData['guest_sign'])):?>
                            	<img src="<?php echo $fileData['guest_sign']?>" class="UerioImg">
                            	<?php endif;?>
                            </div>
                        </div>
                        
                        <div class="pre_Text indentNone pre_over text-poer">
                            <div class="pre_Ado">
                                <span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">旅行社盖章:</div>
                            </div>
                             <div class="pre_Ado">
                                <span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">帮游网盖章:</div>
                            </div>
                            <div class="pre_Ado">
                                <span class=" inputNone pre_block_border jquery_padding"></span>
                                <div class="pre_Ado_title indentNone">签字：</div>
                            </div>
                            <div class="pre_Ado">
                            	<span class=" inputNone pre_block_border jquery_padding underlineH"><?php echo date('Y-m-d' ,time())?></span>
                                <div class="pre_Ado_title indentNone ">日期：</div>
                            </div>
                            <div class=" user-sign-img Imhg">
                            	<?php if (!empty($expertData['sign_pic'])):?>
                            	<img src="<?php echo $expertData['sign_pic']?>" class="signImhg">
                            	<?php endif;?>
                            </div>
                            <div class="user-sign-img text-poer">
                            	<?php if (!empty($fileData['union_sign'])):?>
                            	<img src="<?php echo $fileData['union_sign']?>" class="poerImg">
                            	<?php endif;?>
                            	<?php if (!empty($fileData['bangu_sign'])):?>
                            	<img src="<?php echo $fileData['bangu_sign']?>" class="poerImg2">
                            	<?php endif;?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div id="sign-box">
		<div id="sign-content" class="sign-content"></div>
		<div class="sign-buts">
			<button class="sign-submit">确定</button>
			<button class="sign-reset">重签</button>
			<button class="sign-cancel">取消</button>
		</div>    
    </div>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>


<script src="/assets/js/jSignature-master/libs/modernizr.js"></script>
<script src="/assets/js/jSignature-master/libs/jSignature.min.noconflict.js"></script>


<script type="text/javascript">

    //签字合同 text-indent 计算...
    $(function(){
        for(var i = 0 ; i < $(".jquery_padding").length; i ++ ){
            $(".jquery_padding").eq(i).css("text-indent",$(".jquery_padding").eq(i).siblings(".pre_Ado_title").width());
        }
    })
    
    var signObj;
    var status = 1;
    var contract_status = <?php echo $contractData['status']?>;
    $('#user-sign').click(function(){
    	if (status == 1 && contract_status == 1) {
    		$('#sign-box').show();
    		$('.click-sign').hide();
    		signObj =  $("#sign-content").empty().jSignature({'height':'80%' ,'width':'100%'});
    	}
    })
    //保存签字
    $('.sign-submit').click(function(){
    	//var datapair = signObj.jSignature("getData", "svgbase64");
    	var datapair = signObj.jSignature("getData", "image");
		var base64 = datapair[1];

    	var i = new Image();
    	i.src = "data:" + datapair[0] + "," + datapair[1] ;

		//上传至服务器
		$.ajax({
			url:'/contract/sign_contract/imgHandle',
			type:'post',
			data:{'str':base64 ,'conid':<?php echo $contractData['id']?>},
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					status = 0;
					$(i).appendTo($("#user-sign-img"));
					$("#user-sign-img").find('img').css({'height':'75px'});
					alert(result.msg);
					$('#sign-box').hide();
				} else {
					alert(result.msg);
				}
			}
		});

    })
    $("input").focus(function(){
        $(this).blur();
		return false;
		
        })
    //重新签字
    $('.sign-reset').click(function(){
     	signObj.jSignature('reset');
    })
    //取消签字
    $('.sign-cancel').click(function(){
        $('#sign-box').hide();
    })
    
</script>
</body>
</html>

