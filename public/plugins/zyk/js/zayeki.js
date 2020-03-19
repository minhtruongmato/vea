/*
=========================================================
ZYK SCRIPTS

Author: hungluong
=========================================================
*/

/*
=========================================================
ZYK GLOBAL VARIABLES
=========================================================
*/

const DATA_KEY = 'zyk';

/*
=========================================================
UTIL
=========================================================
*/

const zykKeys = {
    escapeKey: 27
}

const zykUtil = {
    typeOf(obj){
        return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase()
    },

    configSpread(source) {
        let obj = []; 
        for (let i = 0; i< arguments.length; i++){
            let sourceArg = arguments[i] != null ? arguments[i] : {}

            if(this.typeOf(sourceArg) == 'object'){
                obj.push(sourceArg);
            }
        }

        source = obj.reduce(function(r, c){
            return Object.assign(r, c);
        }, {});

        return source;
    },

    bodyBlock(option){
        if(option){
            $('body').removeClass('overflow-on');
            $('body').addClass('overflow-off');
        } else {
            $('body').removeClass('overflow-off');
            $('body').addClass('overflow-on');
        }
    }
}

/*
=========================================================
Helper functions
=========================================================
*/

/*
=========================================================
POAL (POPUP ALERTS)
=========================================================
*/
class Poal {
    constructor(options) {
        let defaultOptions = {
            'type': 'default',
            'title': 'This is Alert Title',
            'message': 'This is the Alert\'s message',

            'cancelButtonClass': 'btn-default',
            'cancelButtonText': 'Cancel',
            'confirmButtonClass': 'btn-success',
            'confirmButtonText': 'Confirm',
        };

        this.options = {
            ...defaultOptions,
            ...options
        };
        
        this.$btn = $('.btn-poal');

        this.fire();
    }

    fire() {
        $('body').append(this.template());

        let _self = this;

        setTimeout(() => {
            _self.transition()
        }, 100)

        this.initEvent();
    }

    transition() {
        $(document).find('.poal').addClass('show');
    }

    initEvent() {
        $(document).on('click', '.btn-cancel', this.dismiss.bind(this));
        $(document).on('click', '.btn-confirm', this.confirm.bind(this));
        $(document).on('click', '.poal-backdrop', this.dismiss.bind(this));
    }

    template() {
        let popup = `
            <div class="poal poal-${this.options.type}">
                <div class="poal-backdrop"></div>
                <div class="poal-dialog">
                    <div class="poal-content">
                        <div class="poal-header">
                            <h3>
                                ${this.options.title}
                            </h3>
                        </div>

                        <div class="poal-body">
                            <p>
                                ${this.options.message}
                            </p>
                        </div>

                        <div class="poal-actions">
                            <button class="btn ${this.options.cancelButtonClass} btn-cancel" type="button">
                                ${this.options.cancelButtonText}
                            </button> 
                            <button class="btn ${this.options.confirmButtonClass} btn-confirm" type="button">
                                ${this.options.confirmButtonText}
                            </button>                        
                        </div>
                    </div>
                </div>
            </div>
        `
        return popup;
    }

    dismiss(e){
        $(e.target).closest('.poal').remove();
    }

    confirm(e){
        $(e.target).closest('.poal').remove();

        this.callbackConfirm();
    }

    callbackConfirm(){
        console.log('callback');
    }
}

/*
=========================================================
POPUP
=========================================================
*/

const POPUP_NAME = 'popup';
const POPUP_EVENT_KEY = `${DATA_KEY}.${POPUP_NAME}`;

const POPUP_CLASSNAME = {
    SHOW: 'show',
    HIDE: 'hide',
    FADE: 'fade',
    FOCUS: 'focus',
    DARK: 'dark',
    DIALOG: 'popup-dialog',
    BACKDROP: 'popup-backdrop',
    BODY: 'popup-body'
}

const POPUP_SELECTOR = {
    DIALOG: `.${POPUP_CLASSNAME.DIALOG}`,
    BACKDROP: `.${POPUP_CLASSNAME.BACKDROP}`,
    POPUP_BODY: `.${POPUP_CLASSNAME.BODY}`,
    TOGGLE: '[data-toggle="popup"]',
    DISMISS: '[data-dismiss="popup"]',
}

const POPUP_DEFAULT = {
    backdrop: true,
    focus: true,
    keyboard: true,
}

const POPUP_DEFAULT_TYPE = {
    backdrop : '(boolean|string)',
    focus: 'boolean',
    keyboard: 'boolean'
}

const POPUP_EVENT = {
    SHOW : `show.${POPUP_EVENT_KEY}`,
    SHOWN : `shown.${POPUP_EVENT_KEY}`,
    HIDE : `hide.${POPUP_EVENT_KEY}`,
    HIDDEN : `hidden.${POPUP_EVENT_KEY}`,
    CLICK_DISMISS: `click.dismiss.${POPUP_EVENT_KEY}`,
    MOUSEDOWN_DISMISS: `mousedown.dismiss.${POPUP_EVENT_KEY}`,
    MOUSEUP_DISMISS: `mouseup.dismiss.${POPUP_EVENT_KEY}`,
    CLICK: `click.${POPUP_EVENT_KEY}`,
    KEYDOWN_DISMISS: `keydown.dismiss.${POPUP_EVENT_KEY}`,
    FOCUSIN: `focusin.${POPUP_EVENT_KEY}`
}

const POPUP_VAR = {
    BACKDROP: null,
    IS_SHOWN: false,
    IGNOREBACKDROPCLICK: false,
    IS_TRANSITION: false,
    TRANSITION: 100 
}

var Popup = function(){
    function Popup(element, config){

        this.config = this.getConfig(config);

        this.backdrop = POPUP_VAR.BACKDROP;
        this.isShown = POPUP_VAR.IS_SHOWN;
        this.ignoreBackdropClick = POPUP_VAR.IGNOREBACKDROPCLICK;
        this.isTransition = POPUP_VAR.IS_TRANSITION;

        this.element = element;
        this.dialog = element.querySelector(POPUP_SELECTOR.DIALOG);

        this.hasFade = $(this.element).hasClass(POPUP_CLASSNAME.FADE);
    }

    const _proto = Popup.prototype;

    _proto.getConfig = function getConfig(config){
        config = zykUtil.configSpread(POPUP_DEFAULT, config);

        return config;
    }

    _proto.toggle = function toggle(target){
        return this.isShown ? this.hide() : this.show(target);
    }

    _proto.show = function show(target) {
        const _this = this;

        // Block body
        zykUtil.bodyBlock(true);

        let showEvent = $.Event(POPUP_EVENT.SHOW, {
            target: target
        });

        $(this.element).trigger(showEvent);

        this.isShown = true;

        this.keepOnViewPort();

        this.setEscapeEvent();

        $(this.element).one(POPUP_EVENT.CLICK_DISMISS, POPUP_SELECTOR.DISMISS, function(e){
            return _this.hide(e);
        });

        $(this.dialog).off(POPUP_EVENT.CLICK_DISMISS);
        $(this.dialog).on(POPUP_EVENT.CLICK_DISMISS, function (e) {
            if($(_this.dialog).is(e.target)){
                return _this.hide(e);
            }
        });

        this.showBackdrop(function(){
            return _this.showElement(target);
        });
    }

    _proto.hide = function hide(e){
        const _this = this;

        if(e){
            e.preventDefault();
        }

        let hideEvent = $.Event(POPUP_EVENT.HIDE);

        $(this.element).trigger(hideEvent);

        this.isShown = false;

        this.hideElement();
    }

    _proto.showElement = function showElement(target){
        const _this = this;

        this.element.style.display = 'block';

        if (this.hasFade) {
            setTimeout(function(){
                $(_this.element).addClass(POPUP_CLASSNAME.SHOW);
            }, POPUP_VAR.TRANSITION)
        } else {
            $(this.element).addClass(POPUP_CLASSNAME.SHOW);
        }

        if($(this.element).attr('tabindex') == null){
            $(this.element).attr('tabindex', -1)
        }

        if(this.config.focus){
            this.forceFocus();
        }

        let shownEvent = $.Event(POPUP_EVENT.SHOWN, {
            target: target
        })

        $(_this.element).trigger(shownEvent);
    }

    _proto.hideElement = function hideElement(){
        const _this = this;

        $(this.element).removeClass(POPUP_CLASSNAME.SHOW);

        if (this.hasFade) {
            setTimeout(function(){
                _this.element.style.display = 'none';
            }, POPUP_VAR.TRANSITION)
        } else {
            this.element.style.display = 'none';
        }

        this.removeBackdrop();

        $(this.element).trigger(POPUP_EVENT.HIDDEN);

        // Unlock body
        zykUtil.bodyBlock(false);
    }

    _proto.showBackdrop = function showBackdrop(callback){
        const _this = this;

        let focus = $(this.element).hasClass(POPUP_CLASSNAME.FOCUS);

        if(this.isShown && this.config.backdrop){
            this.backdrop = $(`<div class="${POPUP_CLASSNAME.BACKDROP}"></div>`);

            if(focus){
                $(this.backdrop).addClass(POPUP_CLASSNAME.FOCUS);
            }

            // Append POPUP BACKDROP to BODY
            $(this.backdrop).appendTo($('body'));
            
            if (this.hasFade) {
                setTimeout(function(){
                    $(_this.backdrop).addClass(POPUP_CLASSNAME.FADE)
                }, POPUP_VAR.TRANSITION)
            } else {
                $(this.backdrop).addClass(POPUP_CLASSNAME.SHOW);
            }

            $(this.backdrop).on(POPUP_EVENT.CLICK_DISMISS, function (e) {
                if(_this.config.backdrop == 'static'){
                    return;
                } else{
                    _this.hide();
                }
            })
        }

        if(callback){
            callback();
        }
    }

    _proto.removeBackdrop = function removeBackdrop(){
        const _this = this;

        if(this.backdrop){
            $(this.backdrop).remove();

            this.backdrop = null;
        }
    }

    _proto.keepOnViewPort = function keepOnViewPort(){
        const _this = this;

        let offsetTop = $(this.element).offset().top;
        let vpHeight = window.innerHeight;

        if(offsetTop > vpHeight){
            let scrollTop = offsetTop - vpHeight * 10 / 100;

            $(window).scrollTop(scrollTop);
        }
    }

    _proto.forceFocus = function forceFocus(){
        const _this = this;

        $(this.element).focus();

        // $(document).off(POPUP_EVENT.FOCUSIN);
        // $(document).on(POPUP_EVENT.FOCUSIN, function(e){
        //     console.log(e);
        //     if (document !== e.target && _this.element !== e.target && $(_this.element).has(e.target).length === 0){
        //         $(_this.element).focus();
        //     }
        // })
    }

    _proto.setEscapeEvent = function setEscapeEvent(){
        const _this = this;

        if(this.isShown && this.config.keyboard){
            $(this.element).one(POPUP_EVENT.KEYDOWN_DISMISS, function(e){
                if(e.which === zykKeys.escapeKey){
                    e.preventDefault();

                    _this.hide();
                }
            })
        } else if (!this.isShown){
            $(this.element).off(POPUP_EVENT.KEYDOWN_DISMISS);
        }
    }

    Popup.jqueryInterface = function jqueryInterface(config, target) {
        return this.each(function(){
            let data = $(this).data(POPUP_EVENT_KEY);

            let _config = zykUtil.configSpread(POPUP_DEFAULT, $(this).data(), typeof config == 'object' && config ? config : {});

            if(!data){
                data = new Popup(this, _config);
                $(this).data(POPUP_EVENT_KEY, data);
            }

            if(typeof config == 'string'){
                if(typeof data[config] == 'undefined'){
                    throw new TypeError('No method named ' + '"' + config + '"');
                }

                data[config](target);
            } else if(_config.toggle){
                data.show(target);
            }
        })
    }

    return Popup;
}();

$(document).on(POPUP_EVENT.CLICK, POPUP_SELECTOR.TOGGLE, function (e) {
    const _this = this;

    let target = $(this).data('target');

    let config = $(target).data(POPUP_EVENT_KEY) ? 'toggle' : zykUtil.configSpread($(target).data(), $(this).data());

    if(this.tagName == 'a'){
        e.preventDefault();
    }

    var $target = $(target).one(POPUP_EVENT.SHOW, function (showEvent) {
        if(showEvent.isDefaultPrevented()){
            return;
        }

        $target.one(POPUP_EVENT.HIDDEN, function(){
            // if($(_this).is(':visible')){
            //     console.log('visible');
            // }
        })
    });

    Popup.jqueryInterface.call($(target), config, this);
});

$.fn[POPUP_NAME] = Popup.jqueryInterface;
$.fn[POPUP_NAME].constructor = Popup;


/*
=========================================================
LISTVIEW
=========================================================
*/

const LISTVIEW_NAME = 'listview';
const LISTVIEW_EVENT_KEY = `${DATA_KEY}.${LISTVIEW_NAME}`;

const LISTVIEW_CLASSNAME = {
    CONTROL: 'list-control',
    HEADER: 'list-header',
    BODY: 'list-body',
    FOOTER: 'list-footer',
}

const LISTVIEW_SELECTOR = {
    CONTROL: `.${POPUP_CLASSNAME.CONTROL}`,
    HEADER: `.${POPUP_CLASSNAME.HEADER}`,
    BODY: `.${POPUP_CLASSNAME.BODY}`,
    FOOTER: `.${POPUP_CLASSNAME.FOOTER}`,
}

const LISTVIEW_VIEW_OPTIONS = {
    LIST: 'list',
    GRID: 'grid'
}

const LISTVIEW_DEFAULT = {
    view: 'list'
};

const LISTVIEW_EVENT = {
    switch: `switch.${LISTVIEW_EVENT_KEY}`,
    switched: `switched.${LISTVIEW_EVENT_KEY}`
}

var Listview = function () {
    function Listview(element, config) {
        this.element = element
    }

    const _proto = Listview.prototype;

    Listview.jqueryInterface = function jqueryInterface(config, target) {
        return this.each(function () {
            let listviewId = $(this).attr('id');
            let listviewMode = localStorage.getItem('listviewMode' + listviewId);

            if(!listviewMode){
                listviewMode = LISTVIEW_VIEW_OPTIONS.LIST;
                localStorage.setItem('listviewMode' + listviewId, listviewMode);

                $(this).addClass('view-' + listviewMode);
            } else{
                console.log('co cmnr con dau nua')
            }
            console.log($(this));
        })
    }

    return Listview;
}();

$.fn[LISTVIEW_NAME] = Listview.jqueryInterface;
$.fn[LISTVIEW_NAME].constructor = Listview;

/*
=========================================================
NAV HEADER
=========================================================
*/
const NAVHEADER_NAME = 'navheader';
const NAVHEADER_EVENT_KEY = `${DATA_KEY}.${NAVHEADER_NAME}`;

const NAVHEADER_CLASSNAME = {
    NAV_MENU: '.nav-menu',

    BTN_EXPAND: '.btn-expand-nav',
    
    SHOW: 'show',
    ACTIVE: 'active'
}

const NAVHEADER_EVENTS = {
    CLICK: `click.${NAVHEADER_EVENT_KEY}`
}

class Navheader{
    constructor(element, options) {
        let defaultOptions = {
        };

        this.options = {
            ...defaultOptions,
            ...options
        };

        this.element = element;

        this.btnExpand = $(this.element).find(NAVHEADER_CLASSNAME.BTN_EXPAND);
        this.navMenu = $(this.element).find(NAVHEADER_CLASSNAME.NAV_MENU);

        this.init();
    }

    init(){
        const _this = this;

        $(document).on(NAVHEADER_EVENTS.CLICK, $(_this.btnExpand), function (e) {
            console.log(_this.btnExpand);
            $(_this.navMenu).toggleClass(NAVHEADER_CLASSNAME.SHOW);
            $(_this.btnExpand).toggleClass(NAVHEADER_CLASSNAME.ACTIVE);

            if ($(_this.btnExpand).hasClass(NAVHEADER_CLASSNAME.ACTIVE)){
                zykUtil.bodyBlock(true);
            } else {
                zykUtil.bodyBlock();
            }
        })
    }
}

