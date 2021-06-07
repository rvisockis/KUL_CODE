<template>
    <div class="wrapper">
      <va-navibar></va-navibar>
      <va-slider></va-slider>
      <va-content-wrap></va-content-wrap>
    </div>
</template>
<script>
    import VANaviBar from './NaviBar.vue'
    import VASlider from './Slider.vue'
    import VAContentWrap from './ContentWrap.vue'
    export default {
              components: {
            'va-navibar': VANaviBar,
            'va-slider': VASlider,
            'va-content-wrap': VAContentWrap
        }
    }
</script>
