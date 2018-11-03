<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>-<?php echo C('WEB_SITE_TITLE');?></title>
    <!-- <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon"> -->
    <link href="<?php echo get_cover(C('SITE_ICO'),'path');?>" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
     <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?bc19aa51515f215def6b091f540c83ea";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo" ><img src="<?php echo get_cover(C('HT_LOGO'),'path');?>" width="100%" height="100%" style="width: 150px;height: 40px;padding-top: 5px;" /></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $key = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($key % 2 );++$key;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><i class="menu_<?php echo ($key); ?>"></i><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <span style="display:block;float:left;margin:0 10px;color:#fff;">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></span>
            <a href="javascript:;" style="float:left;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li><i  class="man_modify"></i><a href="/media.php" target="_blank">网站首页</a></li>
                <li><i  class="man_modify"></i><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><i  class="man_quit"></i><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>   
        </div>
    </div>
    <!-- /头部 -->
    <!-- 边栏 -->
    <div class="sidebar">
        <div class="user_nav">
           <span><img src="/Public/Admin/images/tx.jpg"></span>
           <p><?php echo session('user_auth.username');?></p>
           <p style="margin-top:0px;"><!-- 管理员 --><?php echo ($quanxian); ?></p>
        </div>
        <div  class="fgx">功能菜单</div>
        <!-- 子导航 -->
        
            <div id="subnav" class="subnav">
                <?php if(!empty($_extra_menu)): ?>
                    <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
                <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
                    <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
                        <ul class="side-sub-menu">
                            <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                                    <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul><?php endif; ?>
                    <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        
        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <link href="/Public/Admin/css/stat/group_figure.css" rel="stylesheet" media="all">
    <link href="/Public/Admin/css/stat/echartsHome.css" rel="stylesheet">
    <link href="/Public/Admin/css/stat/default.css" rel="stylesheet">
    <script src="/Public/Admin/js/stat/echarts.js"></script>
    <div class="main-title cf">
    </div>
    <!-- 标签页导航 -->
    <div class="tab-wrap">
      <!-- <ul class="tab-nav nav">
        <li data-tab="tab1" class="current"><a href="javascript:void(0);">基础画像</a></li>
      </ul> -->
      <div class="tab-content"> 
        <!--基础画像-->
        <div id="tab1" class="tab-pane tab1 in">
          <div class="tabFigureContent baseFigure" style="display: block;">
            <!--充值统计 -->
            <div class="dashBoard dashBoardSex">
                <div class="dashBoardContent"> 
                    <script type="text/javascript">    
                        // 路径配置
                        require.config({
                          paths: {
                            echarts: 'http://echarts.baidu.com/build/dist'
                          }
                        });

                        // 使用
                        require(
                          [
                            'echarts',
                            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
                            'echarts/chart/line'
                          ],
                          function (ec) {
                            // 基于准备好的dom，初始化echarts图表
                            var myChart = ec.init(document.getElementById('recharge')); 
                            //设置数据
                            var option = {
                                title : {text: '充值统计',subtext: ''},
                                tooltip : {trigger: 'axis'},
                                legend: {data:['上月', '本月']},
                                calculable : true,
                                xAxis : [{type : 'value',boundaryGap : [0, 0.01]}],
                                yAxis : [{type : 'category',data : ['平台币','微信','支付宝','充值总值(元)']}],
                                series: [
                                    {
                                        name:'上月',type:'bar',
                                        data:[
                                         "<?php echo ($spend_last_data[0]); ?>",
                                         "<?php echo ($spend_last_data[1]); ?>", 
                                         "<?php echo ($spend_last_data[2]); ?>",
                                         "<?php echo ($spend_last_data[3]); ?>"
                                        ]
                                    },
                                    {
                                        name:'本月',type:'bar',
                                        data:[
                                            "<?php echo ($spend_this_data[0]); ?>", 
                                            "<?php echo ($spend_this_data[1]); ?>", 
                                            "<?php echo ($spend_this_data[2]); ?>",
                                            "<?php echo ($spend_this_data[3]); ?>"
                                        ]
                                    }
                                ]
                            };
                            // 为echarts对象加载数据 
                            myChart.setOption(option); 
                          }
                        );        
                    </script>
                    <div id="recharge" class="sj"></div>
                </div>
            </div>
            <!--充值统计END--> 
            <!--注册统计 -->
            <div class="dashBoard dashBoardSex">
                <div class="dashBoardContent"> 
                    <script type="text/javascript"> 
                        // 路径配置
                        require.config({
                          paths: {
                            echarts: 'http://echarts.baidu.com/build/dist'
                          }
                        });

                        // 使用
                        require(
                          [
                            'echarts',
                            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
                            'echarts/chart/line'
                          ],
                          function (ec) {
                            // 基于准备好的dom，初始化echarts图表
                            var myChart = ec.init(document.getElementById('register')); 
                            //设置数据
                            var option = {
                                title : {text: '注册统计',subtext: ''},
                                tooltip : {trigger: 'axis'},
                                legend: {data:['上月', '本月']},
                          
                                calculable : true,
                                xAxis : [{type : 'value',boundaryGap : [0, 0.01]}],
                                yAxis : [{type : 'category',data : ['APP','SDK','WEB','注册总数(人)']}],
                                series: [
                                    {
                                        name:'上月',type:'bar',
                                        data:[
                                         "<?php echo ($reg_last_data[0]); ?>",
                                         "<?php echo ($reg_last_data[1]); ?>", 
                                         "<?php echo ($reg_last_data[2]); ?>",
                                         "<?php echo ($reg_last_data[3]); ?>"
                                        ]
                                    },
                                    {
                                        name:'本月',type:'bar',
                                        data:[
                                         "<?php echo ($reg_this_data[0]); ?>", 
                                         "<?php echo ($reg_this_data[1]); ?>", 
                                         "<?php echo ($reg_this_data[2]); ?>",
                                         "<?php echo ($reg_this_data[3]); ?>"
                                        ]
                                    }
                                ]
                            };
                            // 为echarts对象加载数据 
                            myChart.setOption(option); 
                          }
                        );        
                    </script>
                    <div id="register" class="sj"></div>
                </div>
            </div>
            <!--注册统计END--> 
            <!--充值统计年-->
            <div class="dashBoard dashBoardAge">
                <div class="dashBoardContent"> 
                    <script type="text/javascript">
                        // 路径配置
                        require.config({paths: {echarts: 'http://echarts.baidu.com/build/dist'}});
                        // 使用
                        require(
                          [
                            'echarts',
                            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
                            'echarts/chart/line'
                          ],
                          function (ec) {
                            // 基于准备好的dom，初始化echarts图表
                            var myChart = ec.init(document.getElementById('recharge1')); 
                            //设置数据
                            var option = {
                            title : { text: '充值统计',subtext: ''},
                            tooltip : {trigger: 'axis'},
                            legend: {data:['自然充值','推广充值','总充值']},
                           
                            calculable : true,
                            xAxis : [
                                {
                                    type : 'category',
                                    data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                }
                            ],
                            yAxis : [
                                {type : 'value'}
                            ],
                            series : [
                                {
                                    name:'自然充值',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($ziran_promote[1]); ?>", 
                                    "<?php echo ($ziran_promote[2]); ?>", 
                                    "<?php echo ($ziran_promote[3]); ?>", 
                                    "<?php echo ($ziran_promote[4]); ?>", 
                                    "<?php echo ($ziran_promote[5]); ?>", 
                                    "<?php echo ($ziran_promote[6]); ?>", 
                                    "<?php echo ($ziran_promote[7]); ?>", 
                                    "<?php echo ($ziran_promote[8]); ?>", 
                                    "<?php echo ($ziran_promote[9]); ?>", 
                                    "<?php echo ($ziran_promote[10]); ?>", 
                                    "<?php echo ($ziran_promote[11]); ?>", 
                                    "<?php echo ($ziran_promote[12]); ?>"
                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                },
                                {
                                    name:'推广充值',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($year_promote[1]); ?>", 
                                    "<?php echo ($year_promote[2]); ?>", 
                                    "<?php echo ($year_promote[3]); ?>", 
                                    "<?php echo ($year_promote[4]); ?>", 
                                    "<?php echo ($year_promote[5]); ?>", 
                                    "<?php echo ($year_promote[6]); ?>", 
                                    "<?php echo ($year_promote[7]); ?>", 
                                    "<?php echo ($year_promote[8]); ?>", 
                                    "<?php echo ($year_promote[9]); ?>", 
                                    "<?php echo ($year_promote[10]); ?>", 
                                    "<?php echo ($year_promote[11]); ?>", 
                                    "<?php echo ($year_promote[12]); ?>"
                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                },
                                {
                                    name:'总充值',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($year_total[1]); ?>", 
                                    "<?php echo ($year_total[2]); ?>", 
                                    "<?php echo ($year_total[3]); ?>", 
                                    "<?php echo ($year_total[4]); ?>", 
                                    "<?php echo ($year_total[5]); ?>", 
                                    "<?php echo ($year_total[6]); ?>", 
                                    "<?php echo ($year_total[7]); ?>", 
                                    "<?php echo ($year_total[8]); ?>", 
                                    "<?php echo ($year_total[9]); ?>", 
                                    "<?php echo ($year_total[10]); ?>", 
                                    "<?php echo ($year_total[11]); ?>",
                                    "<?php echo ($year_total[12]); ?>", 

                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                    
                                }
                            ]
                        };
                        // 为echarts对象加载数据 
                        myChart.setOption(option); 
                    }
                    );        
                </script>
                <div id="recharge1" class="sj1"></div>
              </div>
            </div>
            <!--充值统计年END--> 

            <!--注册统计年-->
            <div class="dashBoard dashBoardAge">
                <div class="dashBoardContent"> 
                    <script type="text/javascript">
                        // 路径配置
                        require.config({paths: {echarts: 'http://echarts.baidu.com/build/dist'}});
                        // 使用
                        require(
                          [
                            'echarts',
                            'echarts/chart/bar', // 使用柱状图就加载bar模块，按需加载
                            'echarts/chart/line'
                          ],
                          function (ec) {
                            // 基于准备好的dom，初始化echarts图表
                            var myChart = ec.init(document.getElementById('recharge2')); 
                            //设置数据
                            var option = {
                            title : { text: '注册统计',subtext: ''},
                            tooltip : {trigger: 'axis'},
                            legend: {data:['自然量','推广量','总注册量']},
                           
                            calculable : true,
                            xAxis : [
                                {
                                    type : 'category',
                                    data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
                                }
                            ],
                            yAxis : [
                                {type : 'value'}
                            ],
                            series : [
                                {
                                    name:'自然量',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($ziran_data_year[1]); ?>", 
                                    "<?php echo ($ziran_data_year[2]); ?>", 
                                    "<?php echo ($ziran_data_year[3]); ?>", 
                                    "<?php echo ($ziran_data_year[4]); ?>", 
                                    "<?php echo ($ziran_data_year[5]); ?>", 
                                    "<?php echo ($ziran_data_year[6]); ?>", 
                                    "<?php echo ($ziran_data_year[7]); ?>", 
                                    "<?php echo ($ziran_data_year[8]); ?>", 
                                    "<?php echo ($ziran_data_year[9]); ?>", 
                                    "<?php echo ($ziran_data_year[10]); ?>", 
                                    "<?php echo ($ziran_data_year[11]); ?>",
                                    "<?php echo ($ziran_data_year[12]); ?>", 

                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                },
                                {
                                    name:'推广量',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($prom_data_year[1]); ?>", 
                                    "<?php echo ($prom_data_year[2]); ?>", 
                                    "<?php echo ($prom_data_year[3]); ?>", 
                                    "<?php echo ($prom_data_year[4]); ?>", 
                                    "<?php echo ($prom_data_year[5]); ?>", 
                                    "<?php echo ($prom_data_year[6]); ?>", 
                                    "<?php echo ($prom_data_year[7]); ?>", 
                                    "<?php echo ($prom_data_year[8]); ?>", 
                                    "<?php echo ($prom_data_year[9]); ?>", 
                                    "<?php echo ($prom_data_year[10]); ?>", 
                                    "<?php echo ($prom_data_year[11]); ?>",
                                    "<?php echo ($prom_data_year[12]); ?>", 

                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                },
                                {
                                    name:'总注册量',
                                    type:'bar',
                                    data:[
                                    "<?php echo ($reg_data_year[1]); ?>", 
                                    "<?php echo ($reg_data_year[2]); ?>", 
                                    "<?php echo ($reg_data_year[3]); ?>", 
                                    "<?php echo ($reg_data_year[4]); ?>", 
                                    "<?php echo ($reg_data_year[5]); ?>", 
                                    "<?php echo ($reg_data_year[6]); ?>", 
                                    "<?php echo ($reg_data_year[7]); ?>", 
                                    "<?php echo ($reg_data_year[8]); ?>", 
                                    "<?php echo ($reg_data_year[9]); ?>", 
                                    "<?php echo ($reg_data_year[10]); ?>", 
                                    "<?php echo ($reg_data_year[11]); ?>",
                                    "<?php echo ($reg_data_year[12]); ?>", 

                                    ],
                                    markPoint : {
                                        data : [
                                            {type : 'max', name: '最大值'},
                                            {type : 'min', name: '最小值'}
                                        ]
                                    }
                                    
                                }
                            ]
                        };
                        // 为echarts对象加载数据 
                        myChart.setOption(option); 
                    }
                    );        
                </script>
                <div id="recharge2" class="sj1"></div>
              </div>
            </div>
            <!--注册统计年END-->
          </div>
        </div>
        <!--基础画像结束--> 
      </div>
    </div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.vlcms.com">致晟</a>游戏运营平台 V2.0.6.15</div>
                <div class="fr"></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/admin.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /*初始化导航菜单*/
             $subnav.find(".icon").addClass("icon-fold");
             $subnav.find(".side-sub-menu").siblings(".side-sub-menu").hide();
            
            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");
            //显示选中的菜单
            $subnav.find("a[href='" + url + "']").parent().parent().prev("h3").find("i").removeClass("icon-fold");
            $subnav.find("a[href='" + url + "']").parent().parent().show();

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });
            $("#subnav h3 a").click(function(e){e.stopPropagation()});
            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

            /* 表单获取焦点变色 */
            $("form").on("focus", "input", function(){
                $(this).addClass('focus');
            }).on("blur","input",function(){
                        $(this).removeClass('focus');
                    });
            $("form").on("focus", "textarea", function(){
                $(this).closest('label').addClass('focus');
            }).on("blur","textarea",function(){
                $(this).closest('label').removeClass('focus');
            });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
<script type="text/javascript">
//导航高亮
highlight_subnav('<?php echo U('Stat/daily');?>');
</script>

</body>
</html>