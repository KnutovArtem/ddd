<template>
  <div class='info' hidden>
    <p>Шаг: <span>{{ this.step }}</span></p>
    <p>Категоря: <span>{{
        this.category_id === 0 ? "Хочу машину" : this.category_id === 1 ? "Куплю квартиру" : this.category_id === 2 ? "Закрыть все кредиты" : this.category_id === 3 ? "Открою своё дело" : this.category_id === 4 ? "Просто деньги" : null
                       }} [{{ this.category_id }}]
      </span>
    </p>
    <p>Сумма: <span :class='{blue : this.amount === 3}'>{{
        this.amount === 0 ? "до 500" : this.amount === 1 ? "до 1 млн" : this.amount === 2 ? "до 3 млн" : this.amount === 3 ? "более 3 млн" : null
                                                        }} [{{ this.amount }}]
      </span>
    </p>
    <p>Способ оплаты: <span>{{
        this.purchase_method === 0 ? "Кредит" : this.purchase_method === 1 ? "Лизинг" : this.purchase_method === 2 ? "Откладывать от з.п." : null
                            }} [{{ this.purchase_method }}]
      </span>
    </p>
  </div>
  <main class='main'>

    <Header/>

    <div class='main-content'>

      <!--Start-->
      <div class='section first-screen' v-if='start'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <div class='first-screen__title'>
            <h1 class='h1'>ЧТО ДЕЛАТЬ ЕСЛИ НУЖЕН МИЛЛИОН</h1>
          </div>
          <p class='first-screen__desc'>
            Предлагаю тебе сыграть в игру и выяснить, как выгоднее всего совершать крупные покупки. Выбирай варианты и задавай вопросы. Вместе мы найдём способ решить твои финансовые задачи эффективно, быстро и выгодно.
          </p>
          <button class='button--black' @click='start=false'>Начать</button>
        </div>

      </div>

      <!--Выбор категории-->
      <div class='section' v-if='!this.start && this.step === 0'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p class='section-title' v-html='title'/>
          <div class='buttons'>
            <button class='button--white'
                    v-for='(category_name, id) in data[this.buttons]' :key='id'
                    :class='{active: this.button_active === category_name}'
                    @click='renderButtons(1, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' @click=stepNext();>Начать</button>
        </div>

      </div>

      <!--Выбор суммы-->
      <div class='section' v-if='this.step === 1'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p class='section-title' v-html='title'/>
          <div class='buttons'>
            <button class='button--white'
                    v-for='(category_name, id) in data[this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='renderButtons(2, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' @click=stepNext();>Начать</button>
          <button class='button--back' @click=stepPrev();>Назад</button>
        </div>

      </div>

      <!--Способ покупки-->
      <div class='section' v-if='this.step === 2'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p class='section-title' v-html='title'/>
          <div class='buttons'>
            <button class='button--white'
                    v-for='(category_name, id) in data[this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='renderButtons(3, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' @click=stepNext();>Начать</button>
          <button class='button--back' @click=stepPrev();> Назад</button>
        </div>

      </div>

      <!--Твой выбор ...-->
      <div class='section' v-if='this.step === 3'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p class='section-title' v-html='this.your_choice_title'/>

          <div class='section-desc'>
            <p v-for='desc in this.your_choice_desc' :key='desc' v-html='desc'/>
          </div>
          <button class='button--black' @click='this.next=false; this.step++;' v-html='this.your_choice_button'/>
          <button class='button--back' @click=stepPrev();> Назад</button>
          <button class='button--go'>Хочу кредит</button>
        </div>

      </div>

      <!--Тест-->
      <div class='section' v-if='this.step === 4 && this.purchase_method === 0'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p class='section-title' v-html='this.test_question'/>
          <div class='section-buttons'>
            <button class='button--answer'
                    v-for='(button_answer, index) in this.test_buttons' :key='index'
                    :class='activeClassButton(button_answer)'
                    @click="getAnswer(button_answer['answer']);"
                    v-html='button_answer["name"]'/>
          </div>
          <div class='answer-text' v-if='answer_text'>
            <p v-for='text in this.correct_answer_text' :key='text' v-html='text'/>
          </div>
          <button class='button--black' v-if='!show_button' @click='qestionNext();'>Далее</button>
          <button class='button--black' v-if='show_button' @click='stepNext();'>Давай сравним</button>
          <button class='button--back' @click='qestionPrev();'> Назад</button>
          <button class='button--go'>Хочу кредит</button>
          <div class='' v-if='this.current_question + 1 < this.all_qestions.length'>
            {{ this.current_question + 1 }} из {{ this.all_qestions.length - 1 }}
          </div>
        </div>
      </div>

      <!--Ну что, убедил?-->
      <div class='section' v-if='this.step === 5'>

        <picture class='section-picture monetca'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <div class='table-credits'>
            <p class='table'></p>
            <p class='section-title'> Ну что, убедили? </p>
            <div class='buttons' v-if='this.amount !== 3'> <!--todo: удалить лишнее-->
              <button class='button--black' @click='finalStep(0)'> Хочу автокредит</button>
              <button class='button--white' @click='finalStep(1)'> Хочу потребительский</button>
            </div>
            <div class='buttons' v-if='this.amount === 3'>
              <button class='button--white' @click='finalStep(3)'> Хочу кредит под залог недвижимости </button>
              <button class='button--white' @click='finalStep(1)'> Хочу потребительский</button>
              <button class='button--bd' @click='this.step=8'>Всё ещё сомневаюсь</button>
            </div>
          </div>
          <button class='button--back' @click='this.show_button = false; stepPrev();'> Назад</button>

        </div>
      </div>

      <!--Какой кредит выбран-->
      <div class='section' v-if='this.step === 7'>

        <picture class='section-picture monetca' style='display: none;'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <h1>{{ this.result["title"] }}</h1>
          <div class='info-credits__desc'>
            <p v-for='desc in this.result["desc"]' :key='desc' v-html='desc'/>
          </div>
          <div class='info-credits__buttons'>
            <button class='button&#45;&#45;black'
                    v-for='(button, index) in this.result["buttons"]' :key='index'
                    @click='this.step = 10'
                    v-html='button'/>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

      </div>

      <!--Лизинг | ..немногу от зарплаты -->
      <div class='section' v-if='this.step === 4 && this.purchase_method !== 0'>

        <picture class='section-picture monetca' style='display: none;'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <div class='section-text__desc'>
            <p v-for='desc in this.leasing[this.text_info]["desc"]' :key='desc' v-html='desc'/>
          </div>
          <button class='button--black section-text__button'
                  @click='this.text_info < 1 ? this.text_info++ : this.step = 6;'
                  v-html='this.leasing[this.text_info]["button"]'/>
          <button class='button--back' @click='this.text_info !== 0 ? this.text_info -- : stepPrev();'> Назад</button>
        </div>

      </div>

      <!--Лизинг | ..немногу от зарплаты - общий -->
      <div class='section' v-if='this.step === 6'>

        <picture class='section-picture monetca' style='display: none;'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text' v-if='this.common'>
          <p>
            У нас для тебя два варианта. Самый удобный и выгодный — кредит под залог автомобиля. Выдаём до 3 млн наличными — этого как раз хватит под твои требования. Авто можно взять из салона или с рук и всего от 6,9%. Приятная особенность — мы не требуем КАСКО и дополнительных платежей.
          </p>
          <div class='buttons'>
            <button class='button--black' @click='this.step = 7; this.result_type_credit = 2; getData(this.data);'>6,9% — пушка</button>
            <button class='button--bd' @click='this.common = false'>Хм, залог мне не подходит</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='section-text' v-if='!this.common'>
          <p>
            Залог — это гарантия для банка, что ты выполнишь свои обязательства. Но право собственности останется у тебя и ты не заметишь никаких перемен в повседневной жизни. Авто нельзя продавать, дарить или сдавать в аренду. Зато ты сможешь свободно им пользоваться и даже менять под себя: перекрашивать, тюнинговать, устанавливать противотуманные фары…
          </p>
          <p>Ну что, готов промчаться с ветерком на новом авто? </p>
          <div class='buttons'>
            <button class='button--bd' @click='this.finalStep(0)'>Оформить автокредит</button>
            <button class='button--bd' @click='this.finalStep(1)'>Оформить потребительский кредит</button>
            <button class='button--bd' @click='this.step=8'>Всё ещё сомневаюсь</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

      </div>

      <!--Тут надо хорошенько подумать... -->
      <div class='section' v-if='this.step === 8'>

        <picture class='section-picture monetca' style='display: none;'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/monetca_1.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text'>
          <p>Тут надо хорошенько подумать. Хотя и для такого случая у нас есть несколько предложений.</p>
          <p>Ты можешь взять кредит без залога, но сумма будет не такой большой — до 2 млн рублей. Зато деньги можно получить в ближайшее время: заявку рассматриваем в тот же день, а карту с деньгами привозим на следующий. </p>
          <p>Если нужна сумма побольше, выбирай кредит под залог недвижимости. А если у тебя нет своей, можно договориться с родственниками, чтобы разрешили оформить кредит под залог их квартиры. Квартира останется у них в собственности, а тебе могут одобрить сумму до 15 млн со ставкой от 6,9%. При этом никакой волокиты: для оформления потребуются только паспорт и СНИЛС. </p>
          <p>Оба варианта хороши. Выбирай тот, который больше подходит, и вперёд — к квартире своей мечты!</p>
          <div class='buttons'>
            <button class='button--bd' @click='this.finalStep(1)'>Оформить потребительский кредит</button>
            <button class='button--bd' @click='this.finalStep(2)'>Оформить кредит с залогом</button>
            <button class='button--back' @click='stepPrev();'> Назад</button>
          </div>
        </div>


      </div>

      <!--Finish... -->
      <div class='section' v-if='this.step === 10'>

        <picture class='oppa'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/oppa.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section-text' v-if='this.common'>
          <h1 class=''>Оформить кредит</h1>
        </div>
      </div>

    </div>

  </main>
</template>

<script>
import axios from 'axios'
import Header from './components/header'

export default {
  name: 'App',
  components: {
    Header
  },

  data() {
    return {
      data: [],
      start: true,
      next: false,
      step: 0,
      title: "",
      your_choice_title: "",
      your_choice_desc: "",
      your_choice_button: "",
      category_id: 0,
      amount: 0,
      purchase_method: 0,
      buttons: "categories_name",

      //test
      current_question: 0,
      all_qestions: 7,
      attempt: 0,
      test_question: "",
      test_version: "",
      test_buttons: "",
      correct_answer: "",
      correct_answer_text: "",
      answer_text: false,
      show_button: false,
      result: [],
      result_type_credit: 0,

      // info lizing
      leasing: [],
      text_info: 0,
      test_desc: "",
      common: true,

      // other
      button_active: false,

    }
  },

  methods: {
    finalStep(type_credit) {
      this.step               = 7;
      this.result_type_credit = type_credit;
      this.getData(this.data);
    },
    activeClassButton(button_answer) {
      return {
        true: this.button_active === button_answer["answer"] && button_answer["answer"] === 0,
        false: this.button_active === button_answer["answer"] && button_answer["answer"] === 1
      }
    },
    getData(data) {

      if(this.amount === 3) {
        this.test_version = 'test_2';
        this.purchase_method !== 2 ? this.test_desc = 'desc_2' : this.test_desc = 'desc';
      }else {
        this.test_version = 'test';
        this.test_desc = 'desc';
      }

      this.all_qestions = data['categories'][this.purchase_method][this.test_version];
      this.result       = data["result"][this.result_type_credit];
      this.title        = data['titles'][this.step];

      /*твой выбор*/
      this.your_choice_title  = data['categories'][this.purchase_method]['title'];
      this.your_choice_desc   = data['categories'][this.purchase_method][this.test_desc];
      this.your_choice_button = data['categories'][this.purchase_method]['name_button'];

      /*тест*/
      if (this.purchase_method === 0) {
        this.test_question = data['categories'][this.purchase_method][this.test_version][this.current_question]["question"];
        this.current_question >= 0 ? this.test_buttons = data['categories'][this.purchase_method][this.test_version][this.current_question]['buttons'] : null;
      }
      this.step === 4 && this.next ? this.correct_answer_text = data["categories"][this.purchase_method][this.test_version][this.current_question]["answers"][this.correct_answer]["text"] : null;

      /*Инфо. лизинг*/
      this.leasing = data['categories'][this.purchase_method]['info'];
    },
    stepPrev: function () {

      switch (this.step) {
        case 6:
          this.step = 4;
          break;
        case 7:
          this.amount === 3 ? this.step = 4 : this.step = 5;
          break;
        case 8:
          this.step = 6;
          break;
        default:
          this.step--;
          break;
      }
      //this.step === 6 ? this.step = 4 : this.step === 7 ? this.step = 5 : this.step === 8 ? this.step = 6 : this.step--;
      this.buttons       = this.data["variants_buttons"][this.step];
      this.button_active = false;
      this.next          = false;
      this.getData(this.data);
      this.answer_text = false;
      this.attempt     = 0;
    },
    stepNext: function () {
      this.next ? this.step++ : null;
      this.buttons = this.data["variants_buttons"][this.step];
      this.next    = false;
      this.getData(this.data);
    },
    renderButtons: function (type, id, category_name) {
      type === 1 ? this.category_id = id : null;
      type === 2 ? this.amount = id : null;
      type === 3 ? this.purchase_method = id : null;

      this.button_active = category_name;
      this.next          = true;

      this.getData(this.data);
    },
    getAnswer: function (button_answer) {

      function resetAnswer(that) {
        that.next           = true;
        that.answer_text    = true;
        that.button_active  = button_answer;
        that.correct_answer = button_answer;
        that.getData(that.data);
        that.attempt = 1;
      }

      if (this.current_question !== this.all_qestions.length - 1) {
        this.attempt < 1 ? resetAnswer(this) : null;
      } else {
        this.show_button = true;
        this.attempt < 1 ? button_answer === 1 ? resetAnswer(this) : this.step++ : null;
      }

      // More that one million
      let stopTest = this.amount === 3 && this.current_question + 1 === this.all_qestions.length;
      // if button = true
      if (stopTest && button_answer === 0) {
        this.finalStep(2);
      }
      // if button = false // todo: removed
      /*if (stopTest && button_answer === 1) {
      }*/

    },

    // Следующий вопрос.
    qestionNext: function () {
      if (this.next) {
        this.current_question++;
      }
      this.answer_text   = false;
      this.button_active = false;
      this.next          = false;
      this.attempt       = 0;
      this.getData(this.data);
    },

    // Предыдующий вопрос.
    qestionPrev: function () {
      this.current_question === 0 ? this.step-- : null;
      this.current_question !== 0 ? this.current_question-- : null;
      this.buttons       = this.data["variants_buttons"][this.step]
      this.next          = false;
      this.answer_text   = false;
      this.button_active = false;
      this.buttons       = this.data["variants_buttons"][this.step];
      this.attempt       = 0;
      this.show_button   = false;
      this.getData(this.data);
    }
  },

  mounted() {
    axios
    .get('./data.json')
    .then(response => (this.getData(this.data = response.data)));
  }

}
</script>

<style lang='scss'>
@import "src/styles/main";
</style>

