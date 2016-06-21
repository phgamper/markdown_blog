$('span.obfuscate').each(function (count, enc) { //foreach encoded DOM element
    encodedData = jQuery(enc).html(); //grab encoded text
    decodedData = encodedData.replace(/[a-zA-Z]/g, function (char) { //foreach character
        return String.fromCharCode( //decode string
            /**
             * char is equal/less than 'Z' (i.e. a  capital letter), then compare upper case Z unicode
             * else compare lower case Z unicode.
             *
             * if 'Z' unicode greater/equal than current char (i.e. char is 'Z','z' or a symbol) then
             * return it, else transpose unicode by 26 to return decoded letter
             *
             * can't remember where I found this, and yes it makes my head hurt a little!
             */
            (char <= "Z" ? 90 : 122) >= (char = char.charCodeAt(0) + 13) ? char : char - 26
        );
    });
    jQuery(enc).html(decodedData); // replace text
});