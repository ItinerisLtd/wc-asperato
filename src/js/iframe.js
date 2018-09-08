var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
var eventer = window[eventMethod];
var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";

// Listen to message from child window
eventer(messageEvent, function (e) {
    if (e.origin !== wcAsperato.origin) {
        return;
    }

    if (e.data !== "asp--exit-screen" && e.data !== "asp--complete") {
        return;
    }

    window.location.replace(wcAsperato.redirectUrl);
}, false);
