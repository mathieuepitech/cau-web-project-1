let pointConfig = [
    {
        title: "Test",
        top: 45,
        left: 80,
    },
    {
        title: "Test3",
        top: 125,
        left: 53,
    },
    {
        title: "Test4",
        top: 85,
        left: 170,
    },
    {
        title: "Test5",
        top: 115,
        left: 121,
    },
];

let Point = ( function () {

    let Point = function ( conf, callback ) {
        this.config = conf;
        this.callback = callback;
        this.addSpecificCSS();
        this.adHtml();
    };

    let proto = Point.prototype;

    proto.addSpecificCSS = function () {
        console.log( "Point addSpecificCSS" );
        let css = `<style id="point-css">`;

        for ( let conf of this.config ) {
            css += `
                .${ conf.title }-css {
                    animation: ${ conf.title }-animation 1s linear 0s infinite normal none running;
                    top: ${ conf.top }px;
                    left: ${ conf.left }px;
                }
                .${ conf.title }-css.stop {
                    animation: none;
                }
                @keyframes ${ conf.title }-animation {
                    0% {
                        width: 10px;
                        height: 10px;
                        top: ${ conf.top }px;
                        left: ${ conf.left }px;
                    }
                    50% {
                        width: 20px;
                        height: 20px;
                        top: ${ conf.top - 5 }px;
                        left: ${ conf.left - 5 }px;
                    }
                    100% {
                        width: 10px;
                        height: 10px;
                        top: ${ conf.top }px;
                        left: ${ conf.left }px;
                    }
                }`;
        }
        css += `</style>`;

        if ( $( "#point-css" ).length === 0 ) {
            $( "head" ).append( css.replace( /  |\n/g, "" ) );
        }
    };

    proto.adHtml = function () {
        let container = $( "#point-container" );
        let html = ``;

        for ( let conf of this.config ) {
            html += `<div class="blue darken-3 point ${ conf.title }-css ${ conf.noAnim ? "stop" : "" }"></div>`;
        }
        container.append( html.replace( /  |\n/g, "" ) );
        this.callback( this );
    };

    proto.start = function () {
        let container = $( "#point-container" );

        container.addClass( "start" );
    };

    return Point;
}() );

$( document ).ready( () => {

    $( ".dropdown-trigger" ).dropdown();

    let point;

    new Point( pointConfig, ( p ) => {
        point = p;
        point.start();
    } );

} );