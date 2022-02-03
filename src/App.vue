<template>
  <main class='main' :class='{result: this.step === 10}'>

    <div v-if='false' style='display: flex; justify-content:space-between; width: 100%; padding: 10px 20px 0 20px; position:absolute;' >
      <p style='font-size: 10px;'>пред. шаг - {{ this.step_prev_2 }} / {{ this.step_prev }}</p>
      <p style='font-size: 10px;'>шаг - {{ this.step }}</p>
      <p style='font-size: 10px;'>категория (category_id) - {{ this.category_id }}</p>
      <p style='font-size: 10px;'>цена (amount) {{ this.amount }}</p>
      <p style='font-size: 10px;'>лизинг или (purchase_method) {{ this.purchase_method }}</p>
      <p style='font-size: 10px;'>текущий вопрос (current_question) {{ this.current_question }}</p>
      <p style='font-size: 10px;'>текст (this.text_info) {{ this.text_info }}</p>
      <p style='font-size: 10px;'>(this.info_end_2) {{ this.info_end_2 }}</p>
      <p style='font-size: 10px;'>(this.info_end_3) {{ this.info_end_3 }}</p>
      <p style='font-size: 10px;'>heading - {{ this.result ? this.result["heading"] : '' }}</p>
      <p style='font-size: 10px;'>type_credit - {{ this.result_type_credit }}</p>
    </div>

    <Header :step='this.step'/>

    <div class='main-content'>

      <p class='license_bank' v-if='this.step !== 10'>
        АО «Тинькофф Банк», лицензия ЦБ РФ № 2673
      </p>

      <div class='section first-screen' v-if='start'>

        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/main.webp`)' type='image/webp'>
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
          <button class='first-screen__button button--black'
                  @click='start=false'
                  onclick="dataLayer.push({'event': 'knquiz_start'});">Начать</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 1-->
      <div class='section' v-if='!this.start && this.step === 0' :data-category='this.category_id'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka-money.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-money.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class='`text_${this.step}`'>
          <h2 class='section__heading h2' v-html='this.heading'/>
          <div class='section__buttons' :id='`step-${this.step}`' ref='btns'>
            <button class='button--white'
                    v-for='(category_name, id) in data[this.buttons]' :key='id'
                    :class='{active: this.button_active === category_name}'
                    @click='stepNext(); renderButtons(1, id, category_name);'
                    v-html='category_name'/>
          </div>
          <!--<button class='button&#45;&#45;black' @click='errorClass(this.$refs.btns); stepNext();'>Далее</button>-->
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 2-->
      <div class='section' v-if='this.step === 1'>

        <picture class='section__picture' v-if='this.category_id === 0'>
          <source :srcset='require(`@/img/section/monetka-auto.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-auto.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-if='this.category_id === 1'>
          <source :srcset='require(`@/img/section/monetka-home.png`)' type='image/webp'>
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

        <div class='section__text' :class='`text_${this.step}`'>

          <h2 class='section__heading h2' v-html='heading'/>

          <div class='section__buttons'
               :class='[`amount-${this.purchase_method_id} cat_${this.category_id}`]'
               :id='`step-${this.step}`'
               ref='btns2'>
            <button class='button--white'
                    v-for='(category_name, id) in data["branches"][this.category_id][this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='stepNext(); renderButtons(2, id, category_name);'
                    v-html='category_name'/>
          </div>

          <button class='button--black' v-if='false' @click='errorClass(this.$refs.btns2); stepNext();'>Далее</button>
          <button class='button--back' @click=stepPrev();>Назад</button>

        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 3-->
      <div class='section' id='purchase-method' v-if='this.step === 2'>

        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/monetka__purchase-method.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka__purchase-method.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <h2 class='section__heading h2' v-html='heading'/>
          <div class='section__buttons' :class='`cat_${this.category_id}`' :id='`step-${this.step}`' ref='btns3'>
            <button class='button--white'
                    v-for='(category_name, id) in data["branches"][this.category_id][this.buttons]' :key='id'
                    :class='{active: button_active === category_name}'
                    @click='stepNext(); renderButtons(3, id, category_name);'
                    v-html='category_name'/>
          </div>
          <button class='button--black' v-if='false' @click='errorClass(this.$refs.btns3); stepNext()'>Далее</button>
          <button class='button--back' @click=stepPrev();> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 4-->
      <div class='section' :id='`cat_id_${this.category_id}`' v-if='this.step === 3'>

        <picture class='section__picture'
                 v-if='this.step === 3 && this.purchase_method !== 0'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka-before-finish.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-before-finish.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <picture class='section__picture'
                 v-if='this.step === 3 && this.purchase_method === 0'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka-credits.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-credits.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <div class='section__text'>
          <h2 class='section__heading h2' v-html='this.your_choice_heading'/>

          <div class='section__desc'>
            <p v-for='desc in this.your_choice_desc' :key='desc' v-html='desc'/>
          </div>

          <div class='buttons-container'>
            <button class='button--black'
                    @click='choice()' v-html='this.your_choice_button'/>
            <!--Button "Рассчитать кредит"-->
            <button v-if='this.purchase_method === 0' class='button--bd' @click='showButtonCredit("type_credit")' v-html='showButtonCredit("name_btn")'/>


            <!--            <button class='button&#45;&#45;bd' v-if='this.purchase_method === 0 && this.amount === 0'
                                @click='this.finalStep(0)'>
                                Рассчитать автокредит </button>
                        <button class='button&#45;&#45;bd' v-if='this.purchase_method === 0 && this.amount === 3'
                                @click='this.finalStep(1)'>
                          Рассчитать кредит под залог недвижимости</button>-->
          </div>

          <button class='button--back' @click=stepPrev();> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 5-->
      <div class='section' id='test' v-if='this.step === 4 && this.purchase_method === 0'>

        <picture class='section__picture'
                 v-if='this.test_question === `Если ты вовремя не заплатишь, <br> наложим суровые санкции`'>

          <source :srcset='require(`@/img/section/monetka-terminator.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-terminator.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <picture class='section__picture' v-else>
          <source :srcset='require(`@/img/section/monetka-test.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class='`text_${this.step}`'>

          <h2 class='section__heading h2' v-html='this.test_question'/>

          <div class='section__buttons' ref='btns4'
               :class="[
                   `amount-${this.purchase_method_id}`,
                   `category_id_${this.category_id}`,
                   `${this.current_question === 5 && this.category_id !== 0 ? 'section__buttons__2': '' }`
               ]"
               :id="'step-' + this.step">

            <button v-for='(button_answer, index) in this.test_buttons' :key='index'
                    :class="[ activeClassButton(button_answer),
                              `${this.current_question === 5 && this.category_id !== 0 ? 'button--white-2': 'button--answer' }` ]"
                    @click="getAnswer(button_answer['answer'], button_answer['name']);"
                    v-html='button_answer["name"]'/>
          </div>

          <div class='answer-text' v-if='answer_text'>
            <p v-for='text in this.correct_answer_text' :key='text' v-html='text'/>
          </div>

          <button class='button--black' v-if='!show_button && answer_text' @click='errorClass(this.$refs.btns4);  qestionNext();'>Далее</button>
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
      <!--section - 6-->
      <div class='section' v-if='this.step === 4 && this.purchase_method !== 0'>

        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/monetka-test.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <div class='section__desc'>
            <p v-for='desc in this.leasing[this.text_info]["desc"]' :key='desc' v-html='desc'/>
          </div>
          <div class='section__buttons' :id='`step-${this.step}`' v-if='Array.isArray(this.leasing[this.text_info]["button"])'>
            <button class='button--black section-text__button' ref='btn_anim' v-for='btn in this.leasing[this.text_info]["button"]' :key='btn'
                    @click='animButton(); textInfoNext();'
                    v-html='btn'/>
          </div>
          <div class='section__buttons' :id='`step-${this.step}`' v-else>
            <button class='button--black section-text__button' ref='btn_anim'
                    @click='animButton(); textInfoNext();'
                    v-html='this.leasing[this.text_info]["button"]'/>
          </div>
          <button class='button--back' @click='stepPrev(); animButton()'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 7-->
      <div class='section' id='table' v-if='this.step === 5'>
        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/monetka-test.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-test.png`)' alt='' loading='lazy' rel='preload'>
        </picture>
        <div class='section__text'>

          <div class='table' :class='showTable()'/>

          <p class='section__heading'> Ну что, убедили? </p>

          <div v-if='this.category_id === 0 &&  this.amount !== 3' class='section__buttons' :class="'amount-' + this.purchase_method_id" :id="`'step-${this.step}`">
            <button class='button--black' @click='finalStep(0)'> Хочу автокредит</button>
            <button class='button--black' @click='finalStep(2)'> Нет, хочу потребительский</button>
          </div>
          <div v-else-if='this.category_id === 0 &&  this.amount === 3' class='section__buttons' :class="'amount-' + this.purchase_method_id" :id="`'step-${this.step}`">
            <button class='button--black' @click='finalStep(1)'>Хочу кредит под залог недвижимости</button>
            <button class='button--black' @click='finalStep(2)'>Нет, хочу потребительский</button>
          </div>
          <div v-if='this.category_id !== 0' class='section__buttons' :class="'amount-' + this.purchase_method_id" :id='`step-${this.step}`'>
            <button class='button--black' @click='finalStep(1)'>Хочу кредит под залог недвижимости</button>
          </div>

          <button class='button--back' @click='this.show_button = false; stepPrev();'> Назад</button>

        </div>
        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>
      </div>
      <!--section - 8-->
      <div class='section' v-if='this.step === 6'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka_calc.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka_calc.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <div class='section__text__text-content' v-if='!this.info_end_2 && this.amount !== 3'>
            <p v-for='text in this.text_info_end["text"]' :key='text' v-html='text'/>
          </div>
          <div class='section__text__text-content' v-else-if='this.info_end_3'>
            <p v-for='text in this.text_info_end_3["text"]' :key='text' v-html='text'/>
          </div>
          <div class='section__text__text-content' v-else-if='!this.info_end_2 && this.amount === 3'>
            <p v-for='text in this.text_info_end["text-2"]' :key='text' v-html='text'/>
          </div>
          <div class='section__text__text-content' v-else>
            <p v-for='text in this.text_info_end_2["text"]' :key='text' v-html='text'/>
          </div>

          <div class='section__buttons' :class='`cat_${this.category_id}`' :id='`step-${this.step}`' v-if='!this.info_end_2 && this.amount !== 3'>
            <button class='button--black'
                    v-for='btn in this.text_info_end["buttons"]' :key='btn'
                    @click=' this.result_type_credit = 0; getData(this.data); textInfoNext(btn["next"], btn["name"]);'
                    v-html='btn["name"]'/>
          </div>
          <div class='section__buttons' :class='`cat_${this.category_id}`' :id='`step-${this.step}`' v-else-if='!this.info_end_2 && this.amount === 3'>
            <button class='button--black'
                    v-for='btn in this.text_info_end["buttons-2"]' :key='btn'
                    @click=' this.result_type_credit = 0; getData(this.data); textInfoNext(btn["next"], btn["name"]);'
                    v-html='btn["name"]'/>
          </div>
          <div class='section__buttons' :id='`step-${this.step}`' :class='`cat_${this.category_id}`' v-else-if='this.info_end_3'>
            <button class='button--black'
                    v-for='btn in this.text_info_end_3["buttons"]' :key='btn'
                    @click=' this.result_type_credit = 0; getData(this.data); textInfoNext(btn["next"], btn["name"]);'
                    v-html='btn["name"]'/>
          </div>
          <div class='section__buttons' :id='`step-${this.step}`' :class='`cat_${this.category_id}`' v-else-if='this.info_end_2 && this.amount === 3'>
            <button class='button--black'
                    v-for='btn in this.text_info_end_2["buttons-2"]' :key='btn'
                    @click=' this.result_type_credit = 0; getData(this.data); textInfoNext(btn["next"], btn["name"]);'
                    v-html='btn["name"]'/>
          </div>
          <div class='section__buttons' :class='`cat_${this.category_id}`' :id='`step-${this.step}`' v-else-if='this.info_end_2 && this.amount !== 3'>
            <button class='button--black'
                    v-for='btn in this.text_info_end_2["buttons"]' :key='btn'
                    @click=' this.result_type_credit = 0; getData(this.data); textInfoNext(btn["next"], btn["name"]);'
                    v-html='btn["name"]'/>
          </div>

          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 9-->
      <div class='section' id='type-credit' v-if='this.step === 7'>

        <picture class='section__picture'
                 :class="'pic_' + this.purchase_method"
                 :id="'pic__step-' + this.step">
          <source :srcset='require(`@/img/section/monetka_type-credit.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka_type-credit.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <h2 class='section__heading h2'>{{ this.result["heading"] }}</h2>

          <!--todo: v-if="this.purchase_method === 0 (desc-2)" -->
          <div class='section__desc'>
            <p v-for='desc in this.result["desc"]' :key='desc' v-html='desc'/>
          </div>

          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button--black'
                    v-show='this.result["nameEvent"] === "knquiz_selectkn"'
                    v-for='(button, index) in this.result["buttons"]' :key='index'
                    @click='this.typeCredit(button, this.result["heading"]); this.step = 10;'
                    onclick="fbq('knquiz_selectkn'); VK.Retargeting.Event('knquiz_selectkn'); dataLayer.push({'event': 'knquiz_selectkn'});"
                    v-html='button'/>
            <button class='button--black'
                    v-show='this.result["nameEvent"] === "knquiz_selectknz"'
                    v-for='(button, index) in this.result["buttons"]' :key='index'
                    @click='this.typeCredit(button, this.result["heading"]); this.step = 10;'
                    onclick="fbq('knquiz_selectknz'); VK.Retargeting.Event('knquiz_selectknz'); dataLayer.push({'event': 'knquiz_selectknz'});"

                    v-html='button'/>
            <button class='button--black'
                    v-show='this.result["nameEvent"] === "knquiz_selectkna"'
                    v-for='(button, index) in this.result["buttons"]' :key='index'
                    @click='this.typeCredit(button, this.result["heading"]); this.step = 10;'
                    onclick="fbq('knquiz_selectkna'); VK.Retargeting.Event('knquiz_selectkna'); dataLayer.push({'event': 'knquiz_selectkna'});"
                    v-html='button'/>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 10-->
      <div class='section' v-if='this.step === 8'>

        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/monetka-before-finish.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-before-finish.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text'>
          <p>Тут надо хорошенько подумать. Хотя и&nbsp;для такого случая у&nbsp;нас есть несколько предложений.</p>
          <p>Ты можешь взять кредит без залога, но сумма будет не такой большой — до 2 млн рублей. Зато деньги можно получить в&nbsp;ближайшее время: заявку рассматриваем в&nbsp;тот же день, а&nbsp;карту с деньгами привозим на следующий. </p>
          <p>Если нужна сумма побольше, выбирай кредит под залог недвижимости. А&nbsp;если у&nbsp;тебя нет своей, можно договориться с родственниками, чтобы разрешили оформить кредит под залог их квартиры. Квартира останется у&nbsp;них в&nbsp;собственности, а&nbsp;тебе могут одобрить сумму до 15 млн со ставкой от 8,9%. При этом никакой волокиты: для оформления потребуются только паспорт и&nbsp;СНИЛС. </p>
          <p>Оба варианта хороши. Выбирай тот, который больше подходит, и&nbsp;вперёд — к&nbsp;квартире своей мечты!</p>
          <div class='section__buttons' :id="'step-' + this.step">
            <button class='button--black' @click='this.finalStep(1)'>Оформить потребительский кредит</button>
            <button class='button--black' @click='this.finalStep(1)'>Оформить кредит с залогом</button>
          </div>
          <button class='button--back' @click='stepPrev();'> Назад</button>
        </div>

        <div class='background' :class="'section_' + this.step">
          <div class='blur'></div>
        </div>

      </div>
      <!--section - 11-->
      <div class='section' id='result' v-if='this.step === 10'>

        <picture class='section__picture'>
          <source :srcset='require(`@/img/section/monetka-result.webp`)' type='image/webp'>
          <img class='img' :src='require(`@/img/section/monetka-result.png`)' alt='' loading='lazy' rel='preload'>
        </picture>

        <div class='section__text' :class="'text_' + this.step">
          <h2 class='section__heading' v-if='this.result_type_credit === 0'>Рассчитать автокредит</h2>
          <h2 class='section__heading' v-else>Оформить кредит </h2>

          <p style='color: darkgrey;' v-if='false'>{{ this.result_type_credit }}</p> <!--todo:remove-->

          <div class='iframe'>
            <iframe v-if=' this.result_type_credit === "Автокредит"' width='100%' height='100%' frameborder='0' src='https://www.tinkoff.ru/loans/auto-loan/iframe/form/?parent_url={encodeURIComponent(document.location.href)}'></iframe>

            <iframe  v-if=' this.result_type_credit === "Потребительский кредит"' width='100%' height='100%' frameborder='0' src='https://www.tinkoff.ru/loans/cash-loan/realty/iframe/form/?parent_url={encodeURIComponent(document.location.href)}'></iframe>

            <iframe v-if=' this.result_type_credit === "Кредит под залог недвижимости"' width='100%' height='100%' frameborder='0' src='https://www.tinkoff.ru/loans/cash-loan/iframe/form/?parent_url={encodeURIComponent(document.location.href)}'></iframe>
          </div>

          <div class='license_bank__block'>

            <p>АО «Тинькофф Банк», лицензия ЦБ&nbsp;РФ&nbsp;№&nbsp;2673</p>
            <p>Пример расчета условий по кредиту носит исключительно информационный характер и&nbsp;не является публичной офертой.</p>
            <p>Сумма кредита, указанная в&nbsp;рекламном предложении, не является офертой. Банк определяет сумму кредита по результатам рассмотрения заявки. Процентная ставка, годовых:
              <br>
               1) базовая – от&nbsp;8,9% до&nbsp;30%;
              <br>
               2) при неучастии Клиента в&nbsp;«Программе страховой защиты заемщиков Банка 3.0» (Программа), если требуется кредитным договором – от 12,2% до 30%;
              <br>
               3) при прекращении Договора залога, невыдаче закладной либо признании ее недействительной, если нет обеспечения в&nbsp;виде залога недвижимости:
              <br>
               +5% процентных пунктов (п.п.) к ставке;
              <br>
               4) если не предоставлен договор страхования рисков утраты и&nbsp;повреждения Предмета залога: +0,5% п.п. к ставке. Плата за включение в&nbsp;Программу: 0,3% от Кредита в&nbsp;месяц. Кредит: до 15 млн ₽, срок от&nbsp;3 мес. до&nbsp;15 лет. Условия применимы к Тарифному плану КНЗ 3.15 (рубли РФ). Ставка и&nbsp;иные платежи, определяющие полную стоимость кредита, устанавливаются для каждого Клиента в&nbsp;индивидуальном порядке и&nbsp;указываются в&nbsp;индивидуальных условиях договора кредита под залог недвижимости. Банк вправе запросить иные документы у&nbsp;всех участников сделки. Кредит зачисляется на карту на след. день после регистрации ипотеки в&nbsp;Росреестре или ранее по решению Банка.`</p>

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
  name:       'App',
  components: {
    Header
  },

  data() {
    return {
      production: false,
      data:                [],
      start:               true,
      next:                true,
      step:                0,
      step_prev:           0,
      step_prev_2:         0,
      heading:             "",
      your_choice_heading: "",
      your_choice_desc:    "",
      your_choice_button:  "",
      category_id:         0,
      amount:              0,
      purchase_method:     0,
      purchase_method_id:  0,
      buttons:             "categories_name",

      //test
      current_question:    0,
      all_qestions:        7,
      attempt:             0,
      test_question:       "",
      test_version:        "test",
      test_buttons:        "",
      correct_answer:      "",
      correct_answer_text: "",
      answer_text:         false,
      show_button:         false,
      result:              [],
      result_type_credit:  "",

      // info lizing
      leasing:           [],
      text_info:         0,
      text_info_end:     [],
      text_info_end_2:   [],
      test_desc:         "",
      common:            true,
      branch_accumulate: true,
      info_end_2:        false,
      info_end_3:        false,

      // other
      button_active: false,
      error:         false
    }
  },



  methods: {
    showButtonCredit(e) {

      if (e === "name_btn") {
        let name = "";

        if (this.category_id === 0) {
          this.amount === 3 ? name = "Рассчитать кредит под залог недвижимости" : name = "Рассчитать авто кредит";
        } else {
          this.amount === 0 ? name = `Рассчитать кредит под залог недвижимости до&nbsp;2&#8209;15&nbsp;млн` : name = "Рассчитать потребительский кредит- до 2 млн";
        }

        return name
      }
      if (e === "type_credit") {
        if (this.category_id === 0) {
          this.amount === 3 ? this.finalStep(1) : this.finalStep(0);
        } else {
          this.amount === 0 ? this.finalStep(2) : this.finalStep(1);
        }
      }

    },
    animButton() {
      if (this.$refs.btn_anim) {
        this.$refs.btn_anim.classList.add('anim');
        setTimeout(() => {
          this.$refs.btn_anim.classList.remove('anim');
        }, 2000)
      }
    },

    typeCredit(type, heading) {
      switch (type) {
        case 'Рассчитать потребительский кредит':
        case 'Хочу потребительский кредит':
        case 'Оформить кредит под залог недвижимости':
          this.finalStep(2)
          break;
        case 'Кредит без залога':
        case 'Оформить потребительский кредит':
          this.finalStep(1)
          break;
        case 'Рассчитать кредит':
          if (heading === "Кредит под залог недвижимости") {
            this.finalStep(1)
          }
          break;
        case 'Оформить кредит':
          if (heading === "Кредит под залог недвижимости") {
            this.finalStep(1)
          }
          break;
        default:
          this.finalStep(0)
          break;
      }
    },

    finalStep(type_credit) {
      this.result_type_credit = type_credit;
      this.getData(this.data);
      this.step_prev          = this.step;
      this.step               = 7;
    },

    activeClassButton(button_answer) {
      return {
        true:  this.button_active === button_answer["answer"] && button_answer["answer"] === 0,
        false: this.button_active === button_answer["answer"] && button_answer["answer"] === 1
      }
    },

    getData(data) {
      if (this.amount === 3) {
        this.test_version = 'test_2';
        this.purchase_method !== 2 ? this.test_desc = 'desc_2' : this.test_desc = 'desc';
        this.all_qestions = data["branches"][this.category_id]['categories'][this.purchase_method]['test_2'];
      } else {
        this.test_version = 'test';
        this.test_desc    = 'desc';
        this.all_qestions = data["branches"][this.category_id]['categories'][this.purchase_method]['test'];
      }
      this.result              = data["branches"][this.category_id]["result"][this.result_type_credit];
      this.heading             = data["branches"][this.category_id]['headings'][this.step];
      this.your_choice_heading = data["branches"][this.category_id]['categories'][this.purchase_method]['heading'];
      this.your_choice_desc    = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_desc];
      this.your_choice_button  = data["branches"][this.category_id]['categories'][this.purchase_method]['name_button'];
      if (this.purchase_method === 0) {
        this.test_question = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version][this.current_question]["question"];
        this.current_question >= 0 ? this.test_buttons = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version][this.current_question]['buttons'] : null;
      }
      if (this.step === 4 && this.next) {
        this.correct_answer_text = data["branches"][this.category_id]['categories'][this.purchase_method][this.test_version][this.current_question]["answers"][this.correct_answer]["text"];
      }
      this.leasing         = data["branches"][this.category_id]['categories'][this.purchase_method]['info'];
      this.text_info_end   = data["branches"][this.category_id]['categories'][this.purchase_method]['info-end'];
      this.text_info_end_2 = data["branches"][this.category_id]['categories'][this.purchase_method]['info-end-2'];
      this.text_info_end_3 = data["branches"][this.category_id]['categories'][this.purchase_method]['info-end-3'];

      this.result ? this.result_type_credit = this.result["heading"] : null;
    },

    stepPrev() {
      this.show_button = false;
      this.step_prev === this.step ? this.step_prev = this.step_prev_2 : null

      function resetStepPrev(that) {
        that.buttons       = that.data["variants_buttons"][that.step];
        that.button_active = false;
        //that.next          = false;

        if (that.info_end_2 && that.purchase_method !== 0) {
          that.info_end_2 = true;
        } else {
          that.info_end_2 = false;
        }

        that.getData(that.data);
        that.answer_text = false;
        that.attempt     = 0;
      }

      switch (this.step) {
        case 3:
        case 4:
          if (this.text_info !== 0) {
            this.text_info--
          } else {
            this.step = this.step_prev;
          }
          break;
        case 5:
          if (this.info_end_2 && this.purchase_method !== 0) {
            if (this.category_id === 0) {
              this.step       = 6;
              this.info_end_2 = true;
              return
            } else {
              this.step       = 6;
              this.info_end_2 = true;
              return;
            }
          } else {
            if (this.step_prev === 2) {
              this.step       = this.step_prev;
              this.info_end_2 = true;
            } else {
              this.step = this.step_prev;
            }
          }
          break;
        case 6:
          if (this.info_end_2) {
            this.info_end_2 = false;
          } else {
            if (this.category_id === 0 && this.purchase_method !== 0) {
              this.step      = 4;
              this.text_info = 1;
            } else {
              if (this.text_info === 2) {
                this.text_info = 2;
                if (this.purchase_method === 1) {
                  this.step = 4
                } else {
                  this.step = this.step_prev;
                }
              } else {
                this.step      = 4;
                this.text_info = 1;
              }
            }
          }
          break;
        case 7:
          if (this.info_end_2 && this.purchase_method !== 0) {
            if (this.category_id === 0) {
              if (this.step_prev === 8) {
                this.step = 8;
              } else {
                this.step = 6;
              }
              this.info_end_2 = true;
            } else {
              if (this.step_prev === 5) {
                this.step       = 5;
                this.info_end_2 = true;
              } else {
                this.step       = 6;
                this.info_end_2 = true;
              }
            }
          } else {
            this.step = this.step_prev;
          }
          break;
        case 8:
          if (this.amount === 0) {
            if (this.category_id === 1 || this.category_id === 4) {
              this.step = 4;
            } else {
              this.info_end_2 = true;
              this.step       = 6;
            }
          } else {
            this.step = 6;
          }
          break;
        default:
          this.step--;
          break;
      }

      resetStepPrev(this);

    },

    stepNext() {
      this.step_prev_2 = this.step_prev;
      this.step_prev   = this.step;

      this.next ? this.step === 1 && this.category_id === 2 ? this.step = 3 : this.step++ : null;
      this.buttons = this.data["variants_buttons"][this.step];
      //this.next    = false;
      this.getData(this.data);
    },

    renderButtons(type, id, category_name) {

      type === 1 ? this.category_id = id : null;
      type === 2 ? this.amount = id : null;
      type === 3 ? this.purchase_method = id : null;

      this.purchase_method !== 0 ? this.purchase_method_id = 2 : null;

      this.button_active = category_name;
      this.next          = true;

      this.getData(this.data);
    },

    getAnswer(button_answer, btn_name) {

      function resetAnswer(that) {
        that.next           = true;
        that.answer_text    = true;
        that.button_active  = button_answer;
        that.correct_answer = button_answer;
        that.getData(that.data);
        that.attempt = 1;
      }

      if (this.current_question + 1 !== this.all_qestions.length) {
        if (this.attempt < 1) {
          resetAnswer(this);
        }
      } else if (this.attempt < 1) {

        switch (button_answer) {
          case 0:
            if (this.category_id !== 0) {

              switch (btn_name) {
                case 'Рассчитать кредит':
                case 'Хочу кредит под залог недвижимости':
                  this.finalStep(1);
                  break;
                default:
                  this.finalStep(2);
                  break;
              }

            } else {
              if (this.amount === 3) {
                this.finalStep(1);
              } else {
                this.finalStep(0);
              }
            }
            break;
          case 1:
            resetAnswer(this);
            if (this.category_id !== 0) {
              switch (btn_name) {
                case 'Хочу потребительский':
                  this.finalStep(2)
                  break;
                case 'Хочу кредит без залога':
                  this.finalStep(0)
                  break;
                case 'Сомневаюсь':
                  this.finalStep(1)
                  break;
                default:
                  break;
              }
            } else {
              !this.show_button ? this.show_button = true : this.finalStep(0);
            }
            break;
          case 2:
            switch (btn_name) {
              case 'Сомневаюсь':
                this.finalStep(1);
                break;
              default:
                this.category_id !== 0 ? this.step = 5 : this.finalStep(8);
                break;
            }
            break;
          default:
            this.finalStep(0);
            break;
        }
      }

    },

    qestionNext() {

      if (this.next) {
        this.current_question++;
      }
      this.answer_text   = false;
      this.button_active = false;
      //this.next          = false;
      this.attempt       = 0;
      this.getData(this.data);
    },

    qestionPrev() {

      this.current_question === 0 ? this.step-- : null;
      this.current_question !== 0 ? this.current_question-- : null;
      this.buttons       = this.data["variants_buttons"][this.step]
      //this.next          = false;
      this.answer_text   = false;
      this.button_active = false;
      this.buttons       = this.data["variants_buttons"][this.step];
      this.attempt       = 0;
      this.show_button   = false;
      this.getData(this.data);
    },

    textInfoNext(next, btn_name) {

      if (this.text_info < this.leasing.length - 1) {
        this.text_info++
      } else {
        if (next) {
          switch (next) {
            case 'finalStep_0':
              btn_name === 'Рассчитать потребительский кредит' ? this.finalStep(2) :  this.finalStep(0);
              break;
            case 'finalStep_1':
              switch (btn_name) {
                case 'У меня нет квартиры в&nbsp;собственности':
                  this.finalStep(0)
                  break;
                case 'Рассчитать потребительский кредит':
                  this.finalStep(2)
                  break;
                default:
                  this.finalStep(1)
                  break;
              }
              break;
            case 'finalStep_2':
              switch (btn_name) {
                case 'Рассчитать кредит под залог недвижимости':
                case 'Отлично, выбираю кредит под залог':
                  this.finalStep(1)
                  break;
                default:
                  this.finalStep(2)
                  break;
              }
              break;
            case 'step-8':
              this.category_id !== 0 ? this.step = 5 : this.step = 8;
              break;
            default:
              this.category_id === 2 || this.category_id === 3 && this.info_end_2 || this.category_id === 4 && this.info_end_2 ? this.info_end_3 = true : null;
              this.info_end_2 = true
              this.getData(this.data);
              break;
          }

        } else {
          this.step = 6;
        }
      }

    },

    errorClass(btn) {
      this.error = !this.next;

      function animationMenuItem(from, to) {
        let i       = from;
        let timerId = setInterval(function () {
          btn.children[i].classList.toggle('error');
          if (i === to) {
            clearInterval(timerId);
          }
          i++;
        }, 140);
      }

      if (!this.next) {

        animationMenuItem(0, btn.children.length - 1);
        setTimeout(() => {
          animationMenuItem(0, btn.children.length - 1);
        }, 150)

      }

    },

    choice() {
      this.step_prev_2 = this.step_prev;
      this.step_prev   = this.step;

      //this.next = false;
      this.step === 3 && this.category_id === 3 && this.purchase_method === 4 ? this.step = 6 : this.step++;
    },

    showTable() {
      if (this.category_id === 0 && this.amount === 3 || this.category_id !== 0) {
        return "table-2"
      }
    }
  },

  mounted() {
    this.production = process.env.NODE_ENV === 'production'

    axios.get('./data.json').then(response => (this.getData(this.data = response.data)));
  }

}

</script>

<style lang='scss'>
@import "src/styles/main";
</style>

