<template>
  <header class='header'>
    <a class='header__logo' href='https://www.tinkoff.ru/' target='_blank'></a>
    <div class='header__social' v-if='this.step === 10'>
      <a class='icon icon-ins' href='https://www.instagram.com/TinkoffBank/' target='_blank'></a>
      <a class='icon icon-youtube' href='https://www.youtube.com/user/tcsbank' target='_blank'></a>
      <a class='icon icon-vk' href='https://vk.com/tinkoffbank' target='_blank'></a>
      <a class='icon icon-facebook' href='https://www.facebook.com/tinkoffbank' target='_blank'></a>
    </div>

  </header>
</template>

<script>
export default {
  name: 'FirstScreen',
  props: {
    step: {type: String}
  },
}
</script>

