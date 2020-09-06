(function (global){
    var dc={};

    var lastElementLoop=function(objects){
        var lastCount = 0;
        for (var i in objects){
            var loop=parseInt(i);
            if (Number.isNaN(loop)==false){
                lastCount+=1;
            }
        }
        return (lastCount);
    };

    var insertHtml = function (selector, html) {
        var targetElem = document.querySelector(selector);
        targetElem.innerHTML = html;
      };

    var show_loading = function (selector) {
        var html = "<div class='text-center'>";
        html += "<img src='images/ajax-loader.gif'></div>";
        insertHtml(selector, html);
      };
      
    dc.addNewStep = function(){
        var lastStep=lastElementLoop(document.getElementsByClassName("step"));
        var stepNow=lastStep+1;
        var html="<input id=\"step"+stepNow+"\" name=\"step"+stepNow+"\" class= \"step\" value=\"\" placeholder=\"step"+stepNow+"\" required> <br/> \n<div id=\"newstep"+stepNow+"\"></div>";
        var selector="#newstep"+lastStep;
        insertHtml(selector,html);
    };
    dc.addNewLesson = function(){
        var lastStep=lastElementLoop(document.getElementsByClassName("lesson"));
        var stepNow=lastStep+1;
        var html="<input id=\"lesson"+stepNow+"\" name=\"lesson"+stepNow+"\" class= \"lesson\" value=\"\" placeholder=\"lesson"+stepNow+"\" required> <br/> \n<div id=\"newlesson"+stepNow+"\"></div>";
        var selector="#newlesson"+lastStep;
        insertHtml(selector,html);
    }
    // dc.addNewUnit = function(topic){
    //     //harusnya kalau nambah unit, bakal nambah lesson dan stepsnya jg.
    //     var unitClassName="topic"+topic+"-unit";
    //     var lastStep=lastElementLoop(document.getElementsByClassName(unitClassName));
    //     var stepNow=lastStep+1;
    //     var html="<input id=\"topic"+topic+"-"unit"+stepNow+"\" name=\"topic"+topic+"-unit"+stepNow+"\" class="+unitClassName+" value=\"\" placeholder=\"topic"+topic+"-unit"+stepNow+"\" required> <br/> \n<div id=\"newunit"+stepNow+"\"></div>";
    //     var selector="#newunit"+lastStep;
    //     insertHtml(selector,html);
    // }
    dc.addNewTopic = function(){
        var lastStep=lastElementLoop(document.getElementsByClassName("topic"));
        var stepNow=lastStep+1;
        var html="<input id=\"topic"+stepNow+"\" name=\"topic"+stepNow+"\" class= \"topic\" value=\"\" placeholder=\"topic"+stepNow+"\" required> <br/> \n<div id=\"newtopic"+stepNow+"\"></div>";
        var selector="#newtopic"+lastStep;
        insertHtml(selector,html);
    }

    global.$dc = dc;
})(window);