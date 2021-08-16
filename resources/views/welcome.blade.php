<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://nafezly.com/css/cust-fonts.css">
    <link rel="stylesheet" type="text/css" href="https://nafezly.com/css/fontawsome.min.css">
    <link rel="stylesheet" type="text/css" href="https://nafezly.com/css/responsive-font.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <title>تعرف على قالب وورد بريس</title>
    <style type="text/css">
      *{
        text-decoration: unset!important;
      }
      .fa-spin {
            -webkit-animation: fa-spin .5s linear infinite;
            animation: fa-spin .5s linear infinite;
        }
    </style>
  </head>
  <body>
    <div class="col-12 p-0" id="wp-main-container">

    <div class="col-12 p-0 fixed-top" style="background: #3f51b5;">
      <div class="container p-0" >
        <div class="row px-0 d-flex pt-3" >
          <div class="col d-flex">
            <a href="/" style="color:#fff">
              <span class="fab fa-wordpress font-1  d-inline-block" style="color:#fff"></span> 
              <span class="d-md-inline-block d-none font-1" style="color:#fff; position: relative;"> متعرف على قوالب ووردبريس</span>
            </a>
          </div>
          <div class="col d-flex justify-content-end"> 
            <a href="#" style="color:#fff;" >
              <span class="d-md-inline-block d-none  font-1 ps-2" style="color:#fff; position: relative;"> Github</span>
              <span class="fab fa-github font-1 mb-4 d-inline-block" style="color:#fff"></span> 
            </a>
          </div>
        </div>
      </div> 
    </div>

     <!--  <div style="height: 300px;background: #1f5abc;" class="d-flex justify-content-center align-items-center text-center col-12 p-0">
        <div class="col-12 p-0">
          
          <div class="col-12 p-0">
            <h2 class="text-center d-inline-block mx-auto" style="color:#fff">تعرف على قالب وورد بريس</h2>
          </div>
        </div>
      </div> -->
    
    
    <div class="col-12 py-5" style="min-height:calc( 100vh - 300px)">
       <div class="container">
        <div class="col-12 p-0">
          <div class="col-lg-6 col-12 mx-auto p-0 ">
            <div class="col-12 pt-5">
               <input type="url" v-model="search_input" class="form-control focus-0 rounded-pill px-4 text-center" style="box-shadow: unset!important;height: 50px;" placeholder="إدخل رابط الموقع">
             </div>
             <div class="col-12 py-3 text-center justify-content-center d-flex align-items-center text-center">
               <button class="btn btn-primary rounded-pill px-5 py-2 font-2 d-inline-block mx-auto focus-0" @click="detecting()" style="box-shadow:unset!important;">تعرف على القالب <span class="fas fa-spinner-third fa-spin" v-if="isloading"></span> </button>
             </div>
             <div class="col-12 py-3" v-if="message!=null">
                 <div class="alert" 
                 v-bind:class="'alert-'+message_type" >@{{message}}</div>
             </div>
             <div class="col-12 py-3" v-if="response_date!=null">
                <div class="col-12 py-3" v-if="response_date!=null">
                    <img v-if="response_date.data.thumbnail!=null" v-bind:src="response_date.data.thumbnail" style="width:100%;min-height: 250px;">
                    <div class="col-12 py-3 font-4" style="font-weight: bold;">
                        القالب : @{{response_date.data.theme_name}}
                    </div>
                    <div class="col-12 py-2" v-if="response_date.data.style_links!=null">
                        <h5>لتحميل القالب : </h5>
                        <div class="col-12" v-for="link in response_date.data.style_links">
                            <a v-bind:href="link">@{{link}}</a>
                        </div>



                    </div>
                    <div class="col-12 py-2" v-if="response_date.data.readme_links!=null">
                        <h5>روابط : </h5>
                          <div class="col-12" v-for="link in response_date.data.readme_links">
                            <a v-bind:href="link">@{{link}}</a>
                        </div>
                    </div>
                    <div class="col-12 py-2" v-if="response_date.data.readme_url">
                        <h5>رابط إقراً ايضاً : </h5>
                          <div class="col-12" v-if="response_date.data.readme_url!=null">
                            <a v-bind:href="response_date.data.readme_url">@{{response_date.data.readme_url}}</a>
                        </div>
                    </div>
                    <div class="col-12 py-2" v-if="response_date.data.readme_url">
                        <h5>محتوى إقرأ ايضاً: </h5>
                          <div class="col-12" v-if="response_date.data.readme_content!=null">
                            @{{response_date.data.readme_content}}
                        </div>
                    </div>

                                            

                </div>
                 
             </div>
          </div>
        </div>
         
       </div>
    </div> 




    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      const vue = new Vue({
        el:'#wp-main-container',
        data:{
          search_input:"",
          links:[],
          loaded_text:"",
          isloading:false,
          response_date:null,
          message:null,
          message_type:null,

        },
        methods:{
          detecting(){ 
            this.isloading=true;
            var URL = this.search_input;
             axios.post("{{route('detect')}}",{
                url:URL,
                _token:'{{csrf_token()}}'
              })
              .then(response => {
                  this.response_date = response.data;
                  this.message_type=response.data.message_type;
                  this.message=response.data.message;
                  this.isloading=false;
              }).catch(response=>{
                this.message_type="danger";
                this.response_date=null;
                this.message="برجاء التأكد من صحة البيانات المدخلة";
                this.isloading=false;
              });
          }
        }
      });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>