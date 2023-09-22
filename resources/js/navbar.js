const sidenav = document.getElementById("full-screen-example");
import { Sidenav, initTE,Ripple  } from "tw-elements";

initTE({ Ripple ,Sidenav });


const sidenavInstance = Sidenav.getInstance(sidebar);

let innerWidth = null;

const setMode = (e) => {
    // Check necessary for Android devices
    if (window.innerWidth === innerWidth) {
        return;
    }

    innerWidth = window.innerWidth;

    if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
        sidenavInstance.changeMode("side");
        sidenavInstance.hide();
    } else {
        sidenavInstance.changeMode("side");
        sidenavInstance.show();
    }
};

if (window.innerWidth < sidenavInstance.getBreakpoint("sm")) {
    setMode();
}

// Event listeners
window.addEventListener("resize", setMode);
