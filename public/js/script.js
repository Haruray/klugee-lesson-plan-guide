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
        console.log(html);
        if (!isNull){
            targetElem.className="syllabus-unit";
        }
        $(selector).append(html);
      };
    var isIn=function (array,data){
        len=array.length;
        flag=false;
        for (var i=0;i<len;i++){
            if (array[i]==data){
                flag=true;
            }
        }
        return flag;
    }

    var show_loading = function (selector) {
        var html = "<div class='text-center'>";
        html += "<img src='images/ajax-loader.gif'></div>";
        insertHtml(selector, html);
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
                htmlArrow=document.getElementsByClassName(arrowClass)[0];
                if(response['data'] != null){
                    len = response['data'].length;
                  }
                if (len>0 && htmlArrow.style.transform=='rotate(0deg)'){
                    rotate(htmlArrow,90);
                    var iteration=0;
                    for (var i=0;i<len;i++){
                        var unit=response['data'][i].unit;
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