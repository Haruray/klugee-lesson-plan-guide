(function (global){
    var dc={};

    // var lastElementLoop=function(objects){
    //     var lastCount = 0;
    //     for (var i in objects){
    //         var loop=parseInt(i);
    //         if (Number.isNaN(loop)==false){
    //             lastCount+=1;
    //         }
    //     }
    //     return (lastCount);
    // };

    var insertHtml = function (selector, html,isNull) {
        var targetElem = document.querySelector(selector);
        $(selector).append(html);
      };
    var replaceHtml = function (selector, html,isNull) {
        var targetElem = document.querySelector(selector);
        targetElem.innerHTML=html;
      };
    var isIn=function (array,data){
        length=array.length;
        flag=false;
        for (var j=0;j<length;j++){
            if (array[j]==data){
                flag=true;
            }
        }
        return flag;
    }

    var show_loading = function (selector) {
        var loadingHTML="<div class=\"loader\"></div>"
        replaceHtml(selector,loadingHTML,false);
      };
    var erase_loading = function(selector){
        var HTML="";
        replaceHtml(selector,HTML,false);
    }

    var rotate=function (object,degree){
        finalPos='rotate('+degree+'deg)';
        initialPos='rotate('+(90-degree)+'deg)';
        let start={
            transform:initialPos,
        };
        let end={
            transform:finalPos,
        };
        let options={
            "duration":100
        };
        object.animate([start,end],options);
        object.style.transform = finalPos;
    }

    function fetchData(topic){
        $.ajax({
            url:'/admin/syllabus/'+topic,
            type:'get',
            dataType:'json',
            success:function(response){
                topicHtml=topic.replace(/ /g,"-");
                done=[];
                arrowClass="arrow-"+topicHtml;
                console.log(arrowClass);
                console.log(response);
                htmlArrow=document.getElementsByClassName(arrowClass)[0];
                if(response['data'] != null){
                    len = response['data'].length;
                  }
                if (len>0 && htmlArrow.style.transform=='rotate(0deg)'){
                    rotate(htmlArrow,90);
                    var iteration=0;
                    console.log(response['data']);
                    for (var i=0;i<len;i++){
                        console.log(i);
                        var unit=response['data'][i].unit;
                        console.log("tes");
                        if (unit!=null && !(isIn(done,unit))){
                            done.push(unit);
                            iteration+=1;
                            var unitHtml=
                            "<a href=\"/admin/syllabus/"+topic+"/"+unit+"/\">"+
                                "<p id=\"syllabus-item-unit-text\"><strong>"+iteration+": "+"</strong>"+unit+
                                    "<a href=\"/admin/syllabus/deleteUnit/"+topic+"/"+unit+"\">"+
                                        "<span id=\"delete-button-unit\" class=\"glyphicon glyphicon-trash\"></span>"+
                                    "</a>"+
                                "</p>"+
                            "</a>";
                            selector="#unit-item-"+topicHtml;
                            insertHtml(selector,unitHtml,false);
                        }
                    }
                    htmlAdd="<br/><button id=\"button-add\" type=\"button\" class=\"btn open-AddUnit\" aria-label=\"Left Align\" data-toggle=\"modal\" data-id=\""+topicHtml+"\" data-target=\"#addUnit\">"+
                        "<span class=\"glyphicon glyphicon-plus-sign\" aria-hidden=\"true\"></span><span id=\"button-add-text\">Add new unit</span>"+
                        "</button>";
                    selector="#unit-item-"+topicHtml;
                    insertHtml(selector,htmlAdd,false);
                    
                }
                else{
                    rotate(htmlArrow,0);
                    selector="unit-item-"+topicHtml;
                    try{
                        var element=document.getElementById(selector);
                        element.innerHTML="";
                    }
                    catch(e){
                        console.log(e);
                    }
            }
            }
        })
    }
    dc.fetchUnit=function(topic){
        fetchData(topic);
    }
    dc.fetchStepPhase=function(id){
        arrowClass="arrow-"+id;
        htmlArrow=document.getElementsByClassName(arrowClass)[0];
        if (htmlArrow.style.transform=='rotate(0deg)'){
            rotate(htmlArrow,90);
            var len=3;
            for (var i=0;i<len;i++){
                var phase=['Pre','During','Post']
                if (phase!=null){
                    var phaseHtml=
                    "<a href=\"/admin/syllabus/"+id+"/"+phase[i]+"/steps\">"+
                        "<p id=\"syllabus-item-unit-text\">"+phase[i]+
                        "</p>"+
                    "</a>";
                    selector="#unit-item-"+id;
                    insertHtml(selector,phaseHtml,false);

                }
            }
        }
        else{
            rotate(htmlArrow,0);
            selector="unit-item-"+id;
            try{
                var element=document.getElementById(selector);
                element.innerHTML="";
            }
            catch(e){
                console.log(e);
            }
    }
    }
    var getClassName=function(class_id){
        $.ajax({
            url:'/getclassname/'+class_id,
            type:'get',
            dataType:'json',
            success:function(response){
                console.log(response);
                console.log(response['data']['class_name']);
                return (response['data']['class_name']);
            }
        })
    }

    var isStepCompleted= function(lesson_step_id,data){
        var found=false;
        data['progress'].forEach(element => {
            if (element['lesson_step_id']==lesson_step_id){
                found=true;
            }
        });
        return (found);
    }

    var checkCompletion=function(whatToCheck, itsID, class_id,progressData){
        console.log("completion check");
        console.log(progressData);
        console.log(itsID);
        if (whatToCheck=="unit"){
            //check apakah semua lessonnya sudah selesai atau belum
            //its id adalah id unitnya.
            //cari id yg ada lessonnya
            var validID=-999;
            //karena data syllabus adalah semua data syllabus, kita harus cari data spesifik dari itsID
            var unitName="";
            var topicName="";
            var done=true;
            progressData['syllabus'].forEach(element=>{
                if (element['id']==itsID){
                    unitName=element['unit'];
                    topicName=element['topic'];
                }
            });
            console.log("DEBUG UY")
            console.log(topicName);
            console.log(unitName);
            progressData['syllabus'].forEach(element=>{
                if (element['lesson']!=null && element['unit']==unitName && element['topic']==topicName){
                    validID=element['id'];
                    console.log(validID);
                    //sekarang check apakah stepsnya sudah atau belum
                    progressData['steps'].forEach(elementstep=>{
                        if (elementstep['syllabus_id']==validID){
                            console.log("step_id");
                            console.log(elementstep['id']);
                            done=done && isStepCompleted(elementstep['id'],progressData);
                        }
                    });
                    console.log("is done?");
                    console.log(done);
                    //kalau misal false sekali, berarti isAllDone jadi false;
                }
            });
            if (done){
                return ("button-done");
            }
            else{
                return ("button-text");
            }
        }
        else if (whatToCheck=="lesson"){
            //syllabus id nya adalah itsID. Sekarang check apakah tiap step sudah selesai
            var done=false;
            progressData['steps'].forEach(element=>{
                if (element['syllabus_id']==itsID){
                    done=isStepCompleted(element['id'],progressData);
                }
            });
            
            if (done){
                return ("button-done");
            }
            else{
                return ("button-text");
            }
        }
        else if (whatToCheck=="phase"){
            //ngecek dia phase apa
            //binary search
            var phaseNow="";
            var syllabus_id=0;
            progressData['steps'].forEach(element => {
                if (element['id']==itsID){
                    phaseNow=element['phase'];
                    syllabus_id=element['syllabus_id'];
                }
            });
            //melihat apakah id step sudah berada di table class_progress
            var done=false;
            progressData['steps'].forEach(element=>{
                if (element['phase']==phaseNow && element['syllabus_id']==syllabus_id){
                    done=isStepCompleted(element['id'],progressData);
                }
            });
            
            if (done){
                return ("button-done");
            }
            else{
                return ("button-text");
            }
        }
        else{//whatToCheck=="step"

        }
        return "button-text";
    }

    dc.fetchSelection=function(selection,data,user_id,class_id){
        var selector="#content";
        show_loading(selector);
        $.ajax({
            url:'/get/'+selection+'/'+data+'/'+class_id,
            type:'get',
            dataType:'json',
            success:function(response){
                if(response['data'] != null){
                    var dataLength = response['data'].length;
                  }
                if (selection=='topic'){
                    var target='unit';
                    var progressData=$.parseJSON($.ajax({
                        url:'/getcompletiondata/'+class_id+'/'+target+'/'+'999',
                        type:'get',
                        dataType:'json',
                        async: false,
                    }).responseText);
                }
                else if(selection=='unit'){
                    var target='lesson';
                    var progressData=$.parseJSON($.ajax({
                        url:'/getcompletiondata/'+class_id+'/'+target+'/'+'999',
                        type:'get',
                        dataType:'json',
                        async: false,
                    }).responseText);
                }
                else if(selection=='lesson'){
                    var target='phase';
                    var progressData=$.parseJSON($.ajax({
                        url:'/getcompletiondata/'+class_id+'/'+target+'/'+'999',
                        type:'get',
                        dataType:'json',
                        async: false,
                    }).responseText);
                }
                else{
                    var target='step';
                    var progressData=$.parseJSON($.ajax({
                        url:'/getcompletiondata/'+class_id+'/'+target+'/'+'999',
                        type:'get',
                        dataType:'json',
                        async: false,
                    }).responseText);
                }
                var idName="button";
                var doneList=[];
                if(dataLength>0){
                    var element=document.getElementById('content');
                    element.innerHTML="";
                    response['data'].forEach(element => {
                        if (element[target]!=null && !(isIn(doneList,element[target]))){
                            doneList.push(element[target]);
                            console.log(element);
                            if (selection=='lesson'){
                                idName = checkCompletion(target,element["id"],class_id,progressData);
                                html="<div id=\"button\" class=\"text-center center-block\">"+
                                "<a href=\"/class/"+user_id+"/"+class_id+"/steps"+"/"+element["id"]+"\">"+
                                    "<p id=\""+idName+"\">"+element[target].toUpperCase()+"<p>"+
                                "</a>"+
                                "</div>"
                            }
                            else{
                                //nge ganti idName kalau sudah done;
                                idName = checkCompletion(target,element["id"],class_id,progressData);
                                html="<div id=\"button\" class=\"text-center center-block\">"+
                                "<a onclick=\"$dc.fetchSelection('"+target+"','"+element[target]+"','"+user_id+"','"+class_id+"')\">"+
                                    "<p id=\""+idName+"\">"+element[target]+"<p>"+
                                "</a>"+
                            "</div>"
                            }
                            selector="#content";
                            insertHtml(selector,html,false);
                            
                        }
                    });
                    var anotherHtml="<a onclick=\"$dc.fetchSelectionBack('"+selection+"','"+data+"','"+user_id+"','"+class_id+"')\">"+
                                "<span id=\"arrow\" class=\"glyphicon glyphicon-arrow-left\"></span>"+
                            "</a>";
                    var anotherSelector="#left-corner";
                    if (selection=="topic"){
                        breadHtml="<div id=\"breadcrumb-text\" class=\"custombreadcrumb-item\">"+data+"</div>";
                    }
                    else{
                        var breads=document.getElementsByClassName("custombreadcrumb-item");
                        var breadHtml="<div id=\"breadcrumb-text\" class=\"custombreadcrumb-item\" style=\"font-size:30px;color:white\">"+data+"</div>"
                        if (breads.length>=3){
                            breads[0].parentNode.removeChild(breads[0]);
                        }
                    }
                    var breadSelector="#custombreadcrumb";
                    var headerSelector="#header";
                    var header=target[0].toUpperCase() + target.slice(1);
                    insertHtml(breadSelector,breadHtml,false);
                    replaceHtml(anotherSelector,anotherHtml,false);
                    replaceHtml(headerSelector,header,false);
                }
            }
        })
    }

    dc.fetchSelectionBack=function(selection,data,user_id,class_id){
        var selector="#content";
        show_loading(selector);
        var progressData=$.parseJSON($.ajax({
            url:'/getcompletiondata/'+class_id+'/'+selection+'/'+'999',
            type:'get',
            dataType:'json',
            async: false,
        }).responseText);
        $.ajax({
            url:'/get/'+selection+'/'+data+'/'+class_id+'/back',
            type:'get',
            dataType:'json',
            success:function(response){
                // var selector="#content";
                // show_loading(selector);
                if(response['data'] != null){
                    var dataLength = response['data'].length;
                  }
                var doneList=[];
                var topic='';
                var unit='';
                var lesson='';
                if(dataLength>0){
                    var element=document.getElementById('content');
                    element.innerHTML="";
                    response['data'].forEach(element => {
                        if (element[selection]!=null && !(isIn(doneList,element[selection]))){
                            topic=element['topic'];
                            unit=element['unit'];
                            lesson=element['lesson'];
                            console.log("kontol");
                            doneList.push(element[selection]);
                            idName = checkCompletion(selection,element["id"],class_id,progressData);
                            html="<div id=\"button\" class=\"text-center center-block\">"+
                            "<a onclick=\"$dc.fetchSelection('"+selection+"','"+element[selection]+"','"+user_id+"','"+class_id+"')\">"+
                                "<p id=\""+idName+"\">"+element[selection]+"<p>"+
                            "</a>"+
                            "</div>";
                            selector="#content";
                            insertHtml(selector,html,false);
                            
                        }
                    });
                    if (selection=="topic"){
                        var breads=document.getElementsByClassName("custombreadcrumb-item");
                        breads[breads.length-1].parentNode.removeChild(breads[breads.length-1]);
                        var headerSelector="#header";
                        var header="What do you want to teach?";
                        var anotherHtml="";
                        var anotherSelector="#left-corner";
                        var className=$.parseJSON($.ajax({
                            url:'/getclassname/'+class_id,
                            type:'get',
                            dataType:'json',
                            async: false,
                        }).responseText);
                        className=className['data']['class_name'];
                        console.log(className);
                        var breadSelector="#custombreadcrumb";
                        var breadHtml="<div id=\"breadcrumb-class\" class=\"custombreadcrumb-item\">"+className+"</div>";
                        replaceHtml(breadSelector,breadHtml,false);
                        replaceHtml(anotherSelector,anotherHtml,false);
                        replaceHtml(headerSelector,header,false);
                    }
                    else{
                        if (selection=="unit"){
                            var target="topic";
                            var anotherHtml="<a onclick=\"$dc.fetchSelectionBack('"+target+"','"+topic+"','"+user_id+"','"+class_id+"')\">"+
                                "<span id=\"arrow\" class=\"glyphicon glyphicon-arrow-left\"></span>"+
                            "</a>";
                            var breadHtml="<div id=\"breadcrumb-text\" class=\"custombreadcrumb-item\" style=\"font-size:30px;color:white\">"+topic+"</div>"
                        }
                        else if(selection=="lesson"){
                            var target="unit";
                            var anotherHtml="<a onclick=\"$dc.fetchSelectionBack('"+target+"','"+unit+"','"+user_id+"','"+class_id+"')\">"+
                                "<span id=\"arrow\" class=\"glyphicon glyphicon-arrow-left\"></span>"+
                            "</a>";
                            var breadHtml="<div id=\"breadcrumb-text\" class=\"custombreadcrumb-item\" style=\"font-size:30px;color:white\">"+unit+"</div>"
                        }
            
                        var anotherSelector="#left-corner";
                        var breads=document.getElementsByClassName("custombreadcrumb-item");
                        breads[breads.length-1].parentNode.removeChild(breads[breads.length-1]);
                        var breadSelector="#custombreadcrumb";
                        var headerSelector="#header";
                        var header=selection[0].toUpperCase() + selection.slice(1);
                        // insertHtml(breadSelector,breadHtml,false);
                        replaceHtml(anotherSelector,anotherHtml,false);
                        replaceHtml(headerSelector,header,false);
                        }
                }
            }
        })
    }
    // dc.addNewStep = function(){
    //     var lastStep=lastElementLoop(document.getElementsByClassName("step"));
    //     var stepNow=lastStep+1;
    //     var html="<input id=\"step"+stepNow+"\" name=\"step"+stepNow+"\" class= \"step\" value=\"\" placeholder=\"step"+stepNow+"\" required> <br/> \n<div id=\"newstep"+stepNow+"\"></div>";
    //     var selector="#newstep"+lastStep;
    //     insertHtml(selector,html);
    // };
    // dc.addNewLesson = function(){
    //     var lastStep=lastElementLoop(document.getElementsByClassName("lesson"));
    //     var stepNow=lastStep+1;
    //     var html="<input id=\"lesson"+stepNow+"\" name=\"lesson"+stepNow+"\" class= \"lesson\" value=\"\" placeholder=\"lesson"+stepNow+"\" required> <br/> \n<div id=\"newlesson"+stepNow+"\"></div>";
    //     var selector="#newlesson"+lastStep;
    //     insertHtml(selector,html);
    // }
    // // dc.addNewUnit = function(topic){
    // //     //harusnya kalau nambah unit, bakal nambah lesson dan stepsnya jg.
    // //     var unitClassName="topic"+topic+"-unit";
    // //     var lastStep=lastElementLoop(document.getElementsByClassName(unitClassName));
    // //     var stepNow=lastStep+1;
    // //     var html="<input id=\"topic"+topic+"-"unit"+stepNow+"\" name=\"topic"+topic+"-unit"+stepNow+"\" class="+unitClassName+" value=\"\" placeholder=\"topic"+topic+"-unit"+stepNow+"\" required> <br/> \n<div id=\"newunit"+stepNow+"\"></div>";
    // //     var selector="#newunit"+lastStep;
    // //     insertHtml(selector,html);
    // // }
    // dc.addNewTopic = function(){
    //     var lastStep=lastElementLoop(document.getElementsByClassName("topic"));
    //     var stepNow=lastStep+1;
    //     var html="<input id=\"topic"+stepNow+"\" name=\"topic"+stepNow+"\" class= \"topic\" value=\"\" placeholder=\"topic"+stepNow+"\" required> <br/> \n<div id=\"newtopic"+stepNow+"\"></div>";
    //     var selector="#newtopic"+lastStep;
    //     insertHtml(selector,html);
    // }

    global.$dc = dc;
})(window);