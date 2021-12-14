<template>
  <main class='main'>

    <button class='button--go'
            :class='{right: this.step === 6 || this.step === 4 || this.step === 3}'
            v-if='this.step === 6 || this.step === 3 || this.step === 4 && this.purchase_method === 0'
            @click='this.finalStep(this.purchase_method_id)'>Хочу кредит
    </button>

    <Header/>

    <div class='main-content'>

      <div class='section first-screen' v-if='start'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/main.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <div class='first-screen__heading'>
            <h1 class='h1'>
              ЧТО ДЕЛАТЬ <span class='icon'>ЕСЛИ</span>
              <span class='sat-btn'>НУЖЕН</span>
              <span class='bg'>МИЛЛИОН</span>
            </h1>
          </div>
          <p class='first-screen__desc'>
            Предлагаю тебе сыграть в&nbsp;игру и&nbsp;выяснить, как выгоднее всего совершать крупные покупки. Выбирай варианты и&nbsp;задавай вопросы. Вместе мы найдём способ решить твои финансовые задачи эффективно, быстро и&nbsp;выгодно.
          </p>
          <button class='first-screen__button button--black' @click='start=false'>Начать</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Выбор категории-->
      <div class='section' v-if='!this.start && this.step === 0'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka-money.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-money.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class="'text_' + this.step">
          <h2 class='section__heading h2' v-html='this.heading'/>
          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button--white'
                    v-for='(category_name, id) in data[this.buttons]' :key='id'
                    :class='{active: this.button_active === category_name}'
                    @click='renderButtons(1, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' @click=stepNext();>Далее</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Выбор суммы-->
      <div class='section' v-if='this.step === 1'>

        <picture class='section__picture' v-if='this.category_id === 0'>
          <source :srcset='require(`@/img/section/monetka-auto.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-auto.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-if='this.category_id === 1'>
          <!--          <source :srcset='require(`@/img/section/monetka-home.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-home.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-if='this.category_id === 3'>
          <source :srcset='require(`@/img/section/monetka-result.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-result.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-if='this.category_id === 2 || this.category_id === 4 '>
          <source :srcset='require(`@/img/section/monetka-money.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-money.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class="'text_' + this.step">

          <h2 class='section__heading h2' v-html='heading'/>

          <div class='section__buttons'
               :class="'amount-' + this.purchase_method_id + ' category-' + this.category_id"
               :id="'step-' + this.step">
            <button class='button--white'
                    v-for='(category_name, id) in data["branches"][this.category_id][this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='renderButtons(2, id, category_name);'
                    v-html='category_name'/>
          </div>

          <button class='button--black' @click=stepNext();>Далее</button>
          <button class='button--back' @click=stepPrev();>Назад</button>

        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Способ покупки-->
      <div class='section' id='purchase-method' v-if='this.step === 2'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka__purchase-method.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <h2 class='section__heading h2' v-html='heading'/>
          <div class='section__buttons'
               :class="'cat_' + this.category_id"
               :id="'step-' + this.step">
            <button class='button--white'
                    v-for='(category_name, id) in data["branches"][this.category_id][this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='renderButtons(3, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' @click=stepNext();>Далее</button>
          <button class='button--back' @click=stepPrev();> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Твой выбор ...-->
      <div class='section' v-if='this.step === 3'>

        <picture class='section__picture'
                 v-if='this.step === 3 && this.purchase_method !== 0'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-before-finish.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <picture class='section__picture'
                 v-if='this.step === 3 && this.purchase_method === 0'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-credits.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <h2 class='section__heading h2' v-html='this.your_choice_heading'/>

          <div class='section__desc'>
            <p v-for='desc in this.your_choice_desc' :key='desc' v-html='desc'/>
          </div>

          <button class='button--black' @click='this.next=false; this.step++;' v-html='this.your_choice_button'/>
          <button class='button--back' @click=stepPrev();> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Тест-->
      <div class='section' id='test' v-if='this.step === 4 && this.purchase_method === 0'>

        <picture class='section__picture'
                 v-if='this.current_question + 1 === 5 && this.category_id === 0 && this.amount !== 3'>
          <source :srcset='require(`@/img/section/monetka-terminator.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-terminator.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-else>
          <source :srcset='require(`@/img/section/monetka-test.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class="'text_' + this.step">
          <h2 class='section__heading h2' v-html='this.test_question'/>
          <div class='section__buttons'
               :class="[
                   `amount-${this.purchase_method_id}`,
                   `category_id_${this.category_id}`,
                   `${this.current_question === 5 ? this.category_id === 1 || this.category_id === 4 ? 'section__buttons__2': '' : '' }`
               ]"
               :id="'step-' + this.step">
            <button v-for='(button_answer, index) in this.test_buttons' :key='index'
                    :class="[
                        activeClassButton(button_answer),
                        `${this.current_question === 5 ? this.category_id === 1 || this.category_id === 4 ? 'button--white-2': 'button--answer' : 'button--answer' }`
                        ]"
                    @click="getAnswer(button_answer['answer']);"
                    v-html='button_answer["name"]'/>
          </div>
          <div class='answer-text' v-if='answer_text'>
            <p v-for='text in this.correct_answer_text' :key='text' v-html='text'/>
          </div>
          <button class='button--black' v-if='!show_button' @click='qestionNext();'>Далее</button>
          <button class='button--black' v-if='show_button' @click='stepNext();'>Давай сравним</button>
          <button class='button--back' @click='qestionPrev();'> Назад</button>
          <div class='progress-test' v-if='this.current_question + 1 < this.all_qestions.length'>
            <p>0{{ this.current_question + 1 }}</p>
            <p>из {{ this.all_qestions.length - 1 }}</p>
          </div>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Лизинг | ..немного от зарплаты -->
      <div class='section' v-if='this.step === 4 && this.purchase_method !== 0'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <div class='section__desc'>
            <p v-for='desc in this.leasing[this.text_info]["desc"]' :key='desc' v-html='desc'/>
          </div>
          <button class='button--black section-text__button'
                  @click='this.text_info < 1 ? this.text_info++ : this.step = 6;'
                  v-html='this.leasing[this.text_info]["button"]'/>
          <button class='button--back' @click='this.text_info !== 0 ? this.text_info -- : stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Ну что, убедил?-->
      <div class='section' id='table' v-if='this.step === 5'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <div class='table' :class='this.amount === 3 ? "table-2" : ""'/>
          <p class='section__heading'> Ну что, убедили? </p>
          <div class='section__buttons'
               :class="'amount-' + this.purchase_method_id"
               :id="'step-' + this.step"
               v-if='this.amount !== 3'>
            <button class='button--black' @click='finalStep(0)'> Хочу автокредит</button>
            <button class='button--white-2' @click='finalStep(1)'> Хочу потребительский</button>
          </div>
          <div class='section__buttons'
               :class="'amount-' + this.purchase_method_id"
               :id="'step-' + this.step"
               v-if='this.amount === 3'>
            <button class='button--white-2' @click='finalStep(2)'> Хочу кредит под залог недвижимости</button>
            <button class='button--white-2' @click='finalStep(1)'> Хочу потребительский</button>
            <button class='button--white-2' @click='this.step=8'>Всё ещё сомневаюсь</button>
          </div>
          <button class='button--back' @click='this.show_button = false; stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>
      </div>

      <!--Лизинг | ..немного от зарплаты - общий -->
      <div class='section' v-if='this.step === 6'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka_calc.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' v-if='this.common'>
          <div class='section__text__text-content' v-if='this.amount === 3'>
            <p>Самый удобный и&nbsp;выгодный вариант — кредит под залог недвижимости. Мы предлагаем действительно весомые суммы: до 15 млн наличными по сниженной ставке от 7,9%.</p>
            <p>Ты сможешь оформить сумму больше стоимости авто и&nbsp;потратить остаток на тюнинг, аксессуары или на путешествие — перед нами не нужно отчитываться о покупках 😉</p>
          </div>
          <div class='section__text__text-content' v-else>
            <p>
              У нас для тебя два варианта. Самый удобный и&nbsp;выгодный&nbsp;— кредит под залог автомобиля. Выдаём до 3&nbsp;млн наличными&nbsp;— этого как раз хватит под твои требования. Авто можно взять из салона или с&nbsp;рук&nbsp;и всего от 7,9%. Приятная особенность — мы не требуем КАСКО и&nbsp;дополнительных платежей.
            </p>
            <p>Но, если ты хочешь получить деньги без залога, тогда мы можем договориться на кредит наличными до 2&nbsp;млн рублей по ставке от&nbsp;8,9%. </p>
          </div>
          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button--black'
                    @click='this.step = 7;
                    this.result_type_credit = 0;
                    getData(this.data);
            '>7,9% — пушка
            </button>
            <button class='button--bd' @click='this.common = false'>Хм, залог мне не подходит</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='section__text' v-if='!this.common'>
          <p>
            Залог — это гарантия для банка, что ты выполнишь свои обязательства. Но право собственности останется у тебя и&nbsp;ты не заметишь никаких перемен в&nbsp;повседневной жизни. Авто нельзя продавать, дарить или сдавать в&nbsp;аренду. Зато ты сможешь свободно им пользоваться и&nbsp;даже менять под себя: перекрашивать, тюнинговать, устанавливать противотуманные фары…
          </p>
          <p>Ну что, готов промчаться с ветерком на новом авто? </p>
          <div class='section__buttons' :id="'step-' + this.step + '_' + this.common">
            <button class='button--white-2' @click='this.finalStep(2)'>Хочу кредит под залог недвижимости</button>
            <button class='button--white-2' @click='this.finalStep(1)'>Оформить потребительский кредит</button>
            <button class='button--white-2' @click='this.step=8'>Всё ещё сомневаюсь</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Какой кредит выбран-->
      <div class='section' id='type-credit' v-if='this.step === 7'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka_type-credit.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <h2 class='section__heading h2'>{{ this.result["heading"] }}</h2>
          <div class='section__desc'>
            <p v-for='desc in this.result["desc"]' :key='desc' v-html='desc'/>
          </div>
          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button&#45;&#45;black'
                    v-for='(button, index) in this.result["buttons"]' :key='index'
                    @click='this.step = 10'
                    v-html='button'/>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Тут надо хорошенько подумать... -->
      <div class='section' v-if='this.step === 8'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-before-finish.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <p>Тут надо хорошенько подумать. Хотя и&nbsp;для такого случая у нас есть несколько предложений.</p>
          <p>Ты можешь взять кредит без залога, но сумма будет не такой большой — до 2 млн рублей. Зато деньги можно получить в&nbsp;ближайшее время: заявку рассматриваем в&nbsp;тот же день, а&nbsp;карту с деньгами привозим на следующий. </p>
          <p>Если нужна сумма побольше, выбирай кредит под залог недвижимости. А&nbsp;если у тебя нет своей, можно договориться с родственниками, чтобы разрешили оформить кредит под залог их квартиры. Квартира останется у них в&nbsp;собственности, а&nbsp;тебе могут одобрить сумму до 15 млн со ставкой от 6,9%. При этом никакой волокиты: для оформления потребуются только паспорт и&nbsp;СНИЛС. </p>
          <p>Оба варианта хороши. Выбирай тот, который больше подходит, и&nbsp;вперёд — к&nbsp;квартире своей мечты!</p>
          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button--bd' @click='this.finalStep(1)'>Оформить потребительский кредит</button>
            <button class='button--bd' @click='this.finalStep(2)'>Оформить кредит с залогом</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>

      <!--Finish... -->
      <div class='section' id='result' v-if='this.step === 10'>

        <picture class='section__picture'>
          <!--<source :srcset='require(`@/img/questions/${questions[typeName].resultImg}.webp`)' type='image/webp'>-->
          <img class='img' :src='require(`@/img/section/monetka-result.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class="'text_' + this.step">
          <h2 class='section__heading'>Оформить кредит</h2>
          <div class='iframe'>
            <iframe width='660'
                    height='630'
                    frameborder='0'
                    src='https://www.tinkoff.ru/loans/cash-loan/realty/?dco_ic=5ff4be08-55d8-11ec-8000-000061f0cab5'>
            </iframe>
          </div>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
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
      heading: "",
      your_choice_heading: "",
      your_choice_desc: "",
      your_choice_button: "",
      category_id: 0,
      amount: 0,
      purchase_method: 0,
      purchase_method_id: 0,
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
    //categories_name
    //variants_buttons

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

      if (this.amount === 3) {
        this.test_version = 'test_2';
        this.purchase_method !== 2 ? this.test_desc = 'desc_2' : this.test_desc = 'desc';
      } else {
        this.test_version = 'test';
        this.test_desc    = 'desc';
      }

      this.all_qestions = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version];
      this.result       = data["branches"][this.category_id]["result"][this.result_type_credit];
      this.heading      = data["branches"][this.category_id]['headings'][this.step];

      /*твой выбор*/
      this.your_choice_heading = data["branches"][this.category_id]['categories'][this.purchase_method]['heading'];
      this.your_choice_desc    = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_desc];
      this.your_choice_button  = data["branches"][this.category_id]['categories'][this.purchase_method]['name_button'];

      /*тест*/
      if (this.purchase_method === 0) {
        this.test_question = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version][this.current_question]["question"];
        this.current_question >= 0 ? this.test_buttons = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version][this.current_question]['buttons'] : null;
      }
      this.step === 4 && this.next ? this.correct_answer_text = data["branches"][this.category_id]["categories"][this.purchase_method][this.test_version][this.current_question]["answers"][this.correct_answer]["text"] : null;

      /*Инфо. лизинг*/
      this.leasing = data["branches"][this.category_id]['categories'][this.purchase_method]['info'];
    },
    stepPrev: function () {

      console.log('amount', this.amount);
      console.log('category_id', this.category_id);

      switch (this.step) {
        case 6:
          this.step = 4;
          break;
        case 7:
          if (this.amount === 0 || this.amount === 2 || this.amount === 3) {
            if (this.category_id === 1 || this.category_id === 4) {
              this.step = 4
            } else {
              this.step = 6;
            }
          } else {
            this.step = 5;
          }
          break;
        case 8:
          if (this.amount === 0) {

            if (this.category_id === 1 || this.category_id === 4) {
              this.step = 4;
            }
          } else {
            this.step = 6;
          }
          break;
        default:
          this.step--;
          break;
      }
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

      this.purchase_method !== 0 ? this.purchase_method_id = 2 : null;

      this.button_active = category_name;
      this.next          = true;

      this.getData(this.data);
    },
    getAnswer: function (button_answer) {
      console.clear();

      function resetAnswer(that) {
        that.next           = true;
        that.answer_text    = true;
        that.button_active  = button_answer;
        that.correct_answer = button_answer;
        that.getData(that.data);
        that.attempt = 1;
      }

      if (this.current_question + 1 !== this.all_qestions.length) {
        this.attempt < 1 ? resetAnswer(this) : null;
        console.log('00000');
      } else {
        console.log('11111');
        this.show_button = true;

        if (this.attempt < 1) {
          console.log('2222');
          console.log('button_answer', button_answer);
          switch (button_answer) {
            case 0:
              this.finalStep(1);
              break;
            case 1:
              resetAnswer(this);
              this.finalStep(0);
              break;
            case 2:
              this.step = 8;
              break;
            default:
              this.finalStep(0);
              break;
          }
        }
      }

      // More that one million
      let stopTest = this.amount === 3 && this.current_question + 1 === this.all_qestions.length;

      // if button = true
      if (stopTest && button_answer === 0) {
        this.finalStep(2);
      } else {
        console.log('11');
      }

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

      console.log('amount', this.amount);
      console.log('category_id', this.category_id);

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
    axios.get('./data.json').then(response => (this.getData(this.data = response.data)));
  }

}
</script>

<style lang='scss'>
@import "src/styles/main";
</style>

