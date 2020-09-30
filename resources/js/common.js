export default {
    data() {
        return {

        };
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }

        },
        e(desc, title = "Oops!!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
    },
}
