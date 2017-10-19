(function(){

    document.addEventListener("DOMContentLoaded",function(){
        console.log("DOM content loaded");

        window.addEventListener("online",function(){
            onlineDOM();
        });

        window.addEventListener("offline",function(){
            offlineDOM();
        });

        function offlineDOM(){
            console.log("app is online");
            document.body.style.filter = "grayscale(1)";
        }

        function onlineDOM(){
            console.log("app is offline");
            document.body.style.filter = "";
        }

        if(navigator.onLine){
            onlineDOM();
        }
        else{
           offlineDOM();
        }
    });

})();