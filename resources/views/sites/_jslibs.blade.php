<script>
    function isValidURL(string) {
        var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        return (res !== null)
    };

    function isValidPath(string) {
        if(string === '') {
            return true;
        }

        if(string.includes('//')) {
            return null;
        }

        if (string.substr(-1) === '/') {
            return null;
        }

        var res = string.match(/^[a-z0-9\/\-\_]+$/g);
        return (res !== null)
    }
</script>
