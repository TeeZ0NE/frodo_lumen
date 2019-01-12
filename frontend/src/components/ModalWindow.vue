<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">

        <div class="modal-header">
          <slot name="header">
           <h3>{{modalUser.title}}</h3> 
          </slot>
          <button id="close-wind" name="close-btn" @click="$emit('close')">X</button>
        </div>

        <div class="modal-body">
          <slot name="body">
            <p v-if="modalUser.isEr" slot="body" class="error-msg" v-html="modalUser.erMsg"></p>
        <div class="custom-input">
            <label for="screen-name">Screen Name</label>
            <input v-model.trim="modalUser.screen_name" id="sreen-name" placeholder="Channel name" @input="modalUser.isEr = false">
        </div>
        <div class="custom-input" v-if="(modalUser.name!=='')">
            <label for="name">Name</label>
            <input v-model.trim="modalUser.name" id="name" placeholder="User name" @input="modalUser.isEr = false">
        </div>
        <div class="custom-input">
         <label for="refresh_interval">Refresh interval</label><br>
         <select name="refresh-inerval" id="refresh-interval" v-model="modalUser.refreshInterval">
            <option v-for="value in 12" v-bind:value="value" :key="value">
                {{ value }} hrs
            </option>
        </select>
    </div>
          </slot>
        </div>

        <div class="modal-footer">
          <slot name="footer">
            <button @click="$emit('ok', modalUser)">Ok</button>
              <button class="modal-default-button" @click="$emit('close')">
               Cancel 
             </button>

           </slot>
         </div>
       </div>
     </div>
   </div>
 </template>

 <script>
   export default {
    name: "ModalWindow",
    props: {
      modalUser: {Object}
    },
   }
 </script>

 <style lang="stylus" scoped>
$thead_bgc = #5178ff
$tbody_bgc = #9eccff
 .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
  box-shadow: 5px 5px 2px rgba(0, 0, 0, .5);
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 5px 5px 2px rgba(0, 0, 0, .5);
}

.modal-header {
  color: #fff;
  background-color: $thead_bgc;
  height: 2em;
  padding: .5em;
}

.modal-header h3 {
  margin-top: .3em;
  float: left;
}

.modal-header button {
  float: right;
  padding: 0;
}

.modal-body {
  margin: 20px 0;
  padding: 20px 30px;
}

.modal-body
  input
    width 90%
  select
    width 50% 
  .custom-input
    margin-top 1em

.modal-footer {
  text-align: center;
  padding: 20px 30px;
}

.modal-footer button:last-child {
  margin-left:10px
}
</style>