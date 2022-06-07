import axios from "axios"
export default {
    data() {
        return {

        }
    },
    methods :{
       async  $callApi(method , url ,dataObj){
            try {
                console.log(method , url ,dataObj)
                  return  await  axios({
                    method: method,
                    url: url,
                    data: dataObj,
                })
            } catch (error) {
                console.log(error)
                return error.response 
            }
        }
        , 
         i (desc , title ="Hey") {
                this.$Notice.info({
                    title: title,
                    desc: desc 
                });
            },
            s (desc , title ="Great") {
                this.$Notice.success({
                    title: title,
                    desc: desc 
                });
            },
            warning (desc , title ="Oops") {
                this.$Notice.warning({
                    title: title,
                    desc: desc 
                });
            },
            e(desc="something went wrong lets try again" , title ="Hey") {
                this.$Notice.error({
                    title: title,
                    desc: desc 
                });
            }
    },
  
}