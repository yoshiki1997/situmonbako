<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Title') }}</div>

          <div class="searchbox">
            <form action="/tagssearch" method="GET">
              <input type="text" name="tags" placeholder="キーワードを入れてください">
              <button type="submit">検索</button><br>
              <input type="number" name="limit" v-model="limit" max="100" min="1" />質問数<br>
              <input type="number" name="perPage" v-model="perPage" max="100" min="1" />表示する数
            </form>
          </div>

          <div class="card-body">
            <div v-for="question in questions" :key="question.id">
              <p><a :href="'https://teratail.com/questions/' + question.id" target="_blank">{{ question.title }}</a></p>
            </div>
          </div>

          <p>{{ questionsLinks }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      limit: null,
      perPage: null,
      questions: [],
    };
  },
  computed: {
    questionsLinks() {
        const totalPages = Math.ceil(this.questions.length / this.perPage);
        return `Total pages: ${totalPages}`;
    },
  },
  created() {
    this.limit = this.getInitialValue('limit', 20);
    this.perPage = this.getInitialValue('perPage', 10);
    this.getQuestions();
  },
  methods: {
    getInitialValue(field, defaultValue) {
        const urlParams = new URLSearchParams(window.location.search);
        const paramValue = urlParams.get(field);
        if (paramValue !== null) {
            return paramValue;
        } else {
            return defaultValue;
        }
    },
    getQuestions() {
      // 質問データを取得するAPIリクエストなどのロジックを実装してください
      / 実際のAPIリクエストなどの処理を実装する場合は以下のようなコードを使用できます
         axios.get('/api/questions')
           .then(response => {
             this.questions = response.data;
           })
           .catch(error => {
             console.error(error);
           });
      // 仮のデータを使用する場合は以下のようなコードを使用できます
      this.questions = [
        { id: 1, title: '質問1' },
        { id: 2, title: '質問2' },
        // ...
      ];
    },
  },
};
</script>
