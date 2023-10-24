import _ from "lodash";
import $ from "jquery";
import * as Popper from "@popperjs/core";
import axios from "axios";

window._ = _;

window.$ = $;

window.Popper = Popper;

window.axios = axios;


window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
