<template>
  <div id="app" class="bg-secondary">
    <div class="row bg-secondary" style="margin-right: 0px; margin-left: 0px">
      <div class="col-sm-6 bg-secondary">
        <div class="card">
          <div class="card-body" style="background: darkgray">

              <!-- this is form to insert new Signature -->
            <form action="" class="card-img-top" @submit.prevent="sign" method="POST" autocomplete="off" >
                <!-- we used vueSignature , so write in form vueSignature -->
              <vueSignature ref="signature" id="sig" class="bg-warning" :sigOption="option" :disabled="disabled" :defaultUrl="dataUrl">
              </vueSignature>
            </form>
            <!-- this button is to insert new data or clear -->
            <b-button @click="sign" variant="success" class="m-1"> save </b-button>
            <b-button @click="clear" variant="info" class="m-1">Clear</b-button>
          </div>
          <div></div>
        </div>
      </div>
      <div class="col-sm-6 bg-secondary">
        <div class="card bg-secondary">
          <div class="card-body">
            <table class="table table-bordered">
              <div v-for="book in books" :key="book.id">
                <div v-if="!book.id == 0">
                  <ul>
                    <li>
                      <img :src="'http://localhost:8000/api/store_image/fetch_imag/' + book.id " width="100%" height="" alt="image" />

                      <div class="btn-group" role="group">
                        <button class="btn btn-danger" @click="deleteBook(book.id)">  Delete </button>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import vueSignature from "vue-signature"; 
export default {
  components: {
    vueSignature,  
  },
  data() {
    return {
      books: [],
      png: null,
      user_image: null,
      error: "",
      option: {
        penColor: "rgb(0, 0, 0)",
        backgroundColor: "#ffed4a",
      },

      disabled: false,
      dataUrl: "",
    };
  },

  mounted() {
    this.getPosts();
  },
  methods: {
    getPosts(page_url) {  
      page_url = page_url || "http://localhost:8000/api/posts";

      axios
        .get(page_url)
        .then((response) => {
          this.books = response.data.data;
        })
        .catch((error) => {
          console.log(error);
          this.errored = true;
        })
        .finally(() => (this.loading = false));
    },

    sign() {
      var redirect = this.$auth.redirect();
      var _this = this;
      var png = _this.$refs.signature.save();
      let currentObj = this;
      this.$http.post("auth/sign", { user_image: png }).then((result) => {
        

        this.axios.get("http://localhost:8000/api/books").then((response) => {
          this.books = response.data;
        });
      });
    },
    clear() {
      var _this = this;
      _this.$refs.signature.clear();
    },
    deleteBook(id) {
      this.axios
        .post(`http://localhost:8000/api/store_image/delete/${id}`)
        .then((response) => {
          let i = this.books.map((item) => item.id).indexOf(id); // find index of your object
          this.books.splice(i, 1);
        });
    },
  },
};
</script>


