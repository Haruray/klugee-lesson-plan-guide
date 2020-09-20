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
        // var html = "<div class='text-center'>";
        // html += "<img src=\"{{asset('images/ajax-loader.gif')}}\"></div>";
        var img=document.createElement("img");
        img.src="../images/ajax-loader.gif";
        var target=document.querySelector(selector);
        target.innerHTML="";
        target.append(img);
      };

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
    dc.fetchSelection=function(selection,data,user_id,class_id){
        $.ajax({
            url:'/get/'+selection+'/'+data+'/'+class_id,
            type:'get',
            dataType:'json',
            success:function(response){
                // var selector="#content";
                // show_loading(selector);
                if(response['data'] != null){
                    var dataLength = response['data'].length;
                  }
                if (selection=='topic'){
                    var target='unit';
                }
                else if(selection=='unit'){
                    var target='lesson';
                }
                else if(selection=='lesson'){
                    var target='phase';
                }
                else{
                    var target='step';
                }
                var doneList=[];
                if(dataLength>0){
                    var element=document.getElementById('content');
                    element.innerHTML="";
                    response['data'].forEach(element => {
                        console.log(element[target]);
                        if (element[target]!=null && !(isIn(doneList,element[target]))){
                            doneList.push(element[target]);
                            if (selection=='lesson'){
                                html="<div id=\"button\" class=\"text-center center-block\">"+
                                "<a href=\"/class/"+user_id+"/"+class_id+"/steps/"+element[target]+"\">"+
                                    "<p id=\"button-text\">"+element[target].toUpperCase()+"<p>"+
                                "</a>"+
                                "</div>"
                            }
                            else{
                                html="<div id=\"button\" class=\"text-center center-block\">"+
                                "<a onclick=\"$dc.fetchSelection('"+target+"','"+element[target]+"','"+user_id+"','"+class_id+"')\">"+
                                    "<p id=\"button-text\">"+element[target]+"<p>"+
                                "</a>"+
                            "</div>"
                            }
                            selector="#content";
                            insertHtml(selector,html,false);
                            
                        }
                    });
                    var anotherHtml="<a onclick=\"$dc.fetchSelection('"+selection+"','"+data+"','"+user_id+"','"+class_id+"')\">"+
                                "<span id=\"arrow\" class=\"glyphicon glyphicon-arrow-left\"></span>"+
                            "</a>";
                    var anotherSelector="#left-corner";
                    if (selection=="topic"){
                        breadHtml=data;
                    }
                    else{
                        var breadHtml=" / "+data;
                    }
                    var breadElement=document.getElementById("breadcrumb-text");
                    replaceHtml(anotherSelector,anotherHtml,false);
                    breadElement.innerHTML+=breadHtml;
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