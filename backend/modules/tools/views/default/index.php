<?php
$this->title = 'Roller';

//?>

<style>
    .left {
        width: 700px;
        float:left;
        margin-bottom: 25px;

    }
    .left input {
        width 50px;
    }

    .container {
        width: 1000px;
        margin: 0 auto;
        padding: 0 10px;
    }
    .result {
        width: 500px;
        height: 200px;
        overflow-y: auto;
        border: 1px solid #000000;
    }

</style>
<body>
<div class="container">
    <div class="left">
        <input type="button" class="btn btn-success" value="d4" onclick="roll(4)">
        <input type="button" class="btn btn-success" value="d6" onclick="roll(6)">
        <input type="button" class="btn btn-success" value="d8" onclick="roll(8)">
        <input type="button" class="btn btn-success" value="d10" onclick="roll(10)">
        <input type="button" class="btn btn-success" value="d12" onclick="roll(12)">
        <input type="button" class="btn btn-success" value="d20" onclick="roll(20)">
        <input type="button" class="btn btn-success" value="d100" onclick="roll(100)">
        <input type="text" id="resultContainer">
    </div>

    <div class="left">

            <label>Count</label>
            <input type="text" name="count" id="count" value="1">
            <label>Dice</label>
            <input type="text" name="dice" id="dice" value="6">
            <label>Modifier</label>
            <input type="text" name="modifier" id="modifier" value="0">
            <button class="btn btn-success" onclick="rollMulti();">Roll</button>
            <button class="btn btn-default" onclick="document.getElementById('resultArea').innerHTML = '';">Clear</button>

    </div>
    <div id="resultArea" class="result">

    </div>


</div>
</body>

<script type="text/javascript">
    function roll(base) {
        document.getElementById('resultContainer').setAttribute('value', Math.floor((Math.random() * base) + 1));

    }

    function rollMulti() {
        var count =  parseInt(document.getElementById('count').value);
        console.log(count);
        var dice =  parseInt(document.getElementById('dice').value);
        var modifier = parseInt(document.getElementById('modifier').value);
        var container  = document.getElementById('resultArea');
        container.innerHTML = container.innerHTML+'roll '+count+'d'+dice+((modifier < 0) ? modifier : '+'+modifier)+'</br>';
        for(var i = 0;i< count; i++) {

            container.innerHTML = container.innerHTML+'rolled d'+dice+((modifier < 0) ? modifier : '+'+modifier)+' = '+(Math.floor((Math.random() * dice) + 1)+modifier)+'</br>' ;
        }
    }
</script>



