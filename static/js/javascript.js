let pointConfig = [
    {
        title: "Shoulder",
        top: 45,
        left: 80,
    },
    {
        title: "Biceps",
        top: 85,
        left: 170,
    },
    {
        title: "Abs",
        top: 115,
        left: 121,
    },
    {
        title: "Quadriceps",
        top: 200,
        left: 146,
    },
    {
        title: "Back",
        top: 75,
        left: 347,
    },
    {
        title: "Shoulder",
        second: "1",
        top: 43,
        left: 392,
    },
    {
        title: "Buttocks",
        top: 145,
        left: 327,
    },
    {
        title: "Triceps",
        top: 76,
        left: 300,
    },
    {
        title: "Hamstrings",
        top: 208,
        left: 375,
    },
];

let Point = ( function () {

    let Point = function ( conf, callback ) {
        this.config = conf;
        for ( let i = 0; i < this.config.length; i++ ) {
            if ( this.config[ i ].second ) {
                this.config[ i ].class = this.config[ i ].title.toLowerCase() + this.config[ i ].second;
            } else {
                this.config[ i ].class = this.config[ i ].title.toLowerCase();
            }
        }
        this.callback = callback;
        this.addSpecificCSS();
        this.adHtml();
    };

    let proto = Point.prototype;

    proto.addSpecificCSS = function () {
        let css = `<style id="point-css">`;

        for ( let conf of this.config ) {
            css += `
                .${ conf.class }-css {
                    animation: ${ conf.class }-animation 1s linear 0s infinite normal none running;
                    top: ${ conf.top }px;
                    left: ${ conf.left }px;
                }
                .${ conf.class }-css.stop {
                    animation: none;
                }
                @keyframes ${ conf.class }-animation {
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
            html += `<div data-name="${ conf.title.toLowerCase() }" title="${ conf.title }" class="blue darken-3 point ${ conf.class }-css${ conf.noAnim ? " stop" : "" }"><div></div></div>`;
        }
        container.append( html.replace( /  |\n/g, "" ) );
        this.callback( this );
    };

    proto.listen = function () {
        // Click on a point not selected
        $( document ).on( "click", ".point:not(.selected)", ( elem ) => {
            let $elem = $( elem.target );
            let storageData = localStorage.getItem( "muscles" );

            if ( storageData ) {
                storageData = JSON.parse( storageData );
            }
            $( ".point" ).each( ( i, e ) => {
                let $e = $( e );

                $e.removeClass( "selected" );
            } );

            $elem.addClass( "selected" );
            $( "#exercise-title" ).text( $elem.attr( "title" ) );
            if ( storageData && storageData[ $elem.data( "name" ) ] ) {
                let data = storageData[ $elem.data( "name" ) ];
                let c = $( "#exercises-container" );

                c.empty();
                if ( data.length > 0 ) {
                    for ( let exercise of data ) {
                        c.append( `<div data-id="${ exercise.id }">${ exercise.title }</div>` );
                    }
                } else {
                    c.append( "<div>Please select a muscle</div>" );
                }
            } else {
                $.ajax( {
                    url: "/api/muscles/get-list",
                    method: "POST",
                    data: {
                        muscle: $elem.data( "name" )
                    },
                    success: function ( data ) {
                        data = JSON.parse( data );

                        if ( storageData === null ) {
                            storageData = {};
                        }
                        storageData[ $elem.data( "name" ) ] = data;
                        localStorage.setItem( "muscles", JSON.stringify( storageData ) );

                        let c = $( "#exercises-container" );

                        c.empty();
                        if ( data.length > 0 ) {
                            for ( let exercise of data ) {
                                c.append( `<div data-id="${ exercise.id }">${ exercise.title }</div>` );
                            }
                        } else {
                            c.append( "<div>Please select a muscle</div>" );
                        }
                    }
                } );
            }
        } );

        // Click on a point selected
        $( document ).on( "click", ".point.selected", ( elem ) => {
            let $elem = $( elem.currentTarget );
            let c = $( "#exercises-container" );

            $elem.removeClass( "selected" );
            $( "#exercise-title" ).text( "Selected part of the body" );
            c.html( "<div>Please select a muscle</div>" );
        } );

        // Click on an exercise
        $( document ).on( "click", "#exercises-container div", ( elem ) => {
            let $elem = $( elem.target );
            let storageData = localStorage.getItem( "exercises" );

            if ( storageData ) {
                storageData = JSON.parse( storageData );
            } else {
                storageData = {};
            }
            if ( $elem.data( "id" ) ) {
                if ( storageData[ $elem.data( "id" ) ] ) {
                    let data = storageData[ $elem.data( "id" ) ];
                    let main = $( "#main-container" );
                    let favStorage = localStorage.getItem( "fav" );

                    if ( favStorage ) {
                        favStorage = JSON.parse( favStorage );
                    } else {
                        favStorage = {};
                    }
                    let fav = favStorage[ $elem.data( "id" ) ];

                    main.html( `
                                <div data-id="${ $elem.data( "id" ) }" data-fav="${ fav ? "true" : "false" }" class="right favorite">
                                    <img src="/img/${ fav ? "" : "no-" }favorite.png" alt="">
                                </div>
                                <h2>${ data.title }</h2>
                                <div class="center-align">
                                    <iframe width="560" height="315" src="${ data.video.replace( "https://youtu.be/", "https://www.youtube.com/embed/" ) }" frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    <div class="exercise-info-container blue-grey lighten-4 left-align">${ ( data.description ? data.description : "" ) }</div>
                                </div>
                        ` );
                } else {
                    $.ajax( {
                        url: "/api/muscles/get-exercise",
                        method: "POST",
                        data: {
                            id: $elem.data( "id" ),
                        },
                        success: function ( data ) {
                            data = JSON.parse( data );

                            storageData[ $elem.data( "id" ) ] = data;
                            localStorage.setItem( "exercises", JSON.stringify( storageData ) );

                            let main = $( "#main-container" );
                            let favStorage = localStorage.getItem( "fav" );

                            if ( favStorage ) {
                                favStorage = JSON.parse( favStorage );
                            } else {
                                favStorage = {};
                            }
                            let fav = favStorage[ $elem.data( "id" ) ];

                            main.html( `
                                <div data-id="${ $elem.data( "id" ) }" data-fav="false" class="right favorite">
                                    <img src="/img/${ fav ? "" : "no-" }favorite.png" alt="">
                                </div>
                                <h2>${ data.title }</h2>
                                <div class="center-align">
                                    <iframe width="560" height="315" src="${ data.video.replace( "https://youtu.be/", "https://www.youtube.com/embed/" ) }" frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    <div class="exercise-info-container blue-grey lighten-4 left-align">${ ( data.description ? data.description : "" ) }</div>
                                </div>
                        ` );
                        }
                    } );
                }
            }
        } );

        // On click on favorite
        $( document ).on( "click", ".favorite", ( elem ) => {
            let userId = localStorage.getItem( "userId" );
            let favStorage = localStorage.getItem( "fav" );
            let $elem = $( elem.currentTarget );

            if ( favStorage ) {
                favStorage = JSON.parse( favStorage );
            } else {
                favStorage = {};
            }

            if ( $elem.data( "fav" ) === "true" ) {
                favStorage[ $elem.data( "id" ) ] = false;
                $elem.find( "img" ).attr( "src", "/img/no-favorite.png" );
                $elem.data( "fav", "false" );
                $.ajax( {
                    url: "/api/user/favorite-delete",
                    method: "POST",
                    data: {
                        "id_user": userId,
                        "id_exercise": $elem.data( "id" )
                    }
                } );
            } else {
                favStorage[ $elem.data( "id" ) ] = true;
                $elem.data( "fav", "true" );
                $elem.find( "img" ).attr( "src", "/img/favorite.png" );
                $.ajax( {
                    url: "/api/user/favorite-add",
                    method: "POST",
                    data: {
                        "id_user": userId,
                        "id_exercise": $elem.data( "id" )
                    }
                } );
            }

            localStorage.setItem( "fav", JSON.stringify( favStorage ) );
        } );
    };

    proto.start = function () {
        let container = $( "#point-container" );

        container.addClass( "start" );
        this.listen();
    };

    return Point;
}() );

$( document ).ready( () => {

    let userId = localStorage.getItem( "userId" );
    let userName = localStorage.getItem( "userName" );

    $( ".dropdown-trigger" ).dropdown();

    let point;

    new Point( pointConfig, ( p ) => {
        point = p;
        point.start();
    } );

    if ( userId === null ) {
        $.ajax( {
            url: "/api/user/create",
            method: "POST",
            success: function ( data ) {
                localStorage.setItem( "userId", data.id );
                userId = data.id;
            }, error: function () {
            }
        } );
    }
    if ( userName !== null ) {
        $( "a[data-target=user]" ).html( userName + `<i class="material-icons right">arrow_drop_down</i>` );
    }

    $( document ).on( "click", "#change-name", () => {
        let modal = $( "#modal" );

        modal.find( ".md-title" ).text( "Change Your Name" );
        modal.find( ".md-container" ).html( `
            <div class="row">
                <div class="input-field col s12">
                    <input id="name" type="text" class="validate" value="${ userName !== null ? userName : "" }">
                    <label for="name" ${ userName !== null ? `class="active"` : "" }>Your Name</label>
                </div>
            </div>
        ` );

        modal.find( "#md-validate" ).click( () => {
            $.ajax( {
                url: "/api/user/modify",
                method: "POST",
                data: {
                    "user_id": userId,
                    "name": $( "#name" ).val()
                },
                success: function ( data ) {
                    localStorage.setItem( "userId", data.is );
                    localStorage.setItem( "userName", data.name );
                    $( "a[data-target=user]" ).html( data.name + `<i class="material-icons right">arrow_drop_down</i>` );
                    modal.removeClass( "md-show" );
                    modal.find( "md-title" ).empty();
                    modal.find( ".md-container" ).empty();
                },
            } );
        } );
        modal.find( "#md-cancel" ).click( () => {
            modal.removeClass( "md-show" );
            modal.find( "md-title" ).empty();
            modal.find( ".md-container" ).empty();
        } );
        modal.addClass( "md-show" );
    } );

    $( document ).on( "click", "#your-exercise", function () {
        let favStorage = localStorage.getItem( "fav" );
        let exercisesStorage = localStorage.getItem( "exercises" );
        let main = $( "#main-container" );

        main.empty();
        if ( favStorage ) {
            localStorage = JSON.parse( favStorage );
            console.log( favStorage );
            if ( exercisesStorage ) {
                exercisesStorage = JSON.parse( exercisesStorage );
            }
            for ( let id in favStorage ) {
                if ( favStorage.hasOwnProperty( id ) ) {
                    if ( favStorage[ id ] ) {
                        if ( exercisesStorage.hasOwnProperty( id ) ) {
                            main.append( `
                                <div data-id="${ id }" data-fav="false" class="right favorite">
                                    <img src="/img/favorite.png" alt="">
                                </div>
                                <h2>${ exercisesStorage[ id ].title }</h2>
                                <div class="center-align">
                                    <iframe width="560" height="315" src="${ exercisesStorage[ id ].video.replace( "https://youtu.be/", "https://www.youtube.com/embed/" ) }" frameborder="0"
                                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    <div class="exercise-info-container blue-grey lighten-4 left-align">${ ( exercisesStorage[ id ].description ? exercisesStorage[ id ].description : "" ) }</div>
                                </div>
                            ` );
                        }
                    }
                }
            }
        } else {

        }
    } );

} );