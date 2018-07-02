/*  计算刑期 二级分类的实现*/ 
    $(function() {  

        var charge = $("#charge");  
        var specific = $("#specific");  
        var term = $("#term");  
        var preCharge = "<option value=\"\">请选择</option>";  
        var preSpecific = "<option value=\"\">请选择</option>";  
        //初始化  
        charge.html(preCharge);  
        specific.html(preSpecific);  
        
          
        //文档加载完毕:即从sentenceSelectInfo.xml获取数据,成功之后采用  
        //func_suc_getXmlCharge进行 罪名分类的 解析  
        $.ajax({  
            type : "GET",
            //test79.lvshiwangzhan.com/statics/js/sentenceSelectInfo.xml 
            url : "static/sentenceSelectInfo.xml",  
            success : func_suc_getXmlCharge  
        });  
          
        //具体罪名点击事件  
        charge.change(function() { 
            $("#term").empty();
            $("#specific").css("color","red"); 
            
            //提示信息的显示
                $("#reminder").show() ;         
                //根据下拉得到的罪名对于的下标序号,动态从从sentenceSelectInfo.xml获取数据,成功之后采用  
                //func_suc_getXmlCharge进行罪名对应的具体罪名的解析  
                $.ajax({  
                    type : "GET",  
                    url : "static/sentenceSelectInfo.xml",  
                    success : func_suc_getXmlspecific  
                });  
  

        });
       
          
        //具体罪名 下拉选择发生变化触发的事件  
        specific.change(function() {
            $("#specific").css("color","#717070"); 
            term.html(); 
            $.ajax({  
                type : "GET",  
                url : "static/sentenceSelectInfo.xml",  
                  
                //根据下拉得到的罪名分类、具体罪名对于的下标序号,动态从从sentenceSelectInfo.xml获取数据,成功之后采用  
                //func_suc_getXmlTerm进行罪名分类对应的具体罪名对应的刑期的解析  
                success : func_suc_getXmlTerm  
            });  
        });  
          
   
          
        //解析获取xml格式文件中的charge标签,得到所有的罪名分类,并逐个进行遍历 放进下拉框中  
        function func_suc_getXmlCharge(xml) {  
            // charge.empty();           
            //jquery的查找功能              
            var fenlei = $(xml).find("charge");  
              
            //jquery的遍历与查询匹配 eq功能,并将其放到下拉框中  
            fenlei.each(function(i) {  
                charge.append("<option value=" + i + ">"  
                        + fenlei.eq(i).attr("text") + "</option>");  
            }); 
            $("#charge option").eq(0).disabled=true;
        }  
          
        function func_suc_getXmlspecific(xml) {  
            var xml_fenlei = $(xml).find("charge");  
            var fenlei_num = parseInt(charge.val());  
            var xml_juti = xml_fenlei.eq(fenlei_num).find("specific");  
            specific.empty();
            specific.append("<option > 请选择</option>");
            xml_juti.each(function(j) {  
                specific.append("<option  value=" + j + ">"  
                        + xml_juti.eq(j).attr("text") + "</option>");  
            });  
        }  
          
        function func_suc_getXmlTerm(xml) {  
            var xml_fenlei = $(xml).find("charge");  
            var fenlei_num = parseInt(charge.val());  
            var xml_juti = xml_fenlei.eq(fenlei_num).find("specific");  
            var juti_num = parseInt(specific.val());  
            var xml_xingqi = xml_juti.eq(juti_num).find("term");  
                term.html("<p>构成：</p><p>"+xml_xingqi.attr("constitute")+"</p><p>刑期：</p><p>"
                    +xml_xingqi.attr("term1")+"</p><p>"
                    +xml_xingqi.attr("term2")+"</p><p>"
                    +xml_xingqi.attr("term3")+"</p>"
                    )  
           
        } 

    });