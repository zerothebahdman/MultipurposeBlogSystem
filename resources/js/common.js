export default {
    data() {
        return {

        };
    },
    methods: {
        callApi(method, url, dataObj) {
            try {
                return axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }

        }
    },
}
