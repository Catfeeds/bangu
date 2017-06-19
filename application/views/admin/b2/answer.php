
<style>
dt,dd{line-height:30px;height:30px;}
dd{padding-left:20px;}
</style>

<?php foreach ($answers_list as $key => $item): ?>
<dl>
<dt><?php echo '问题' . ($key+1) . ':' . $item['question']?></dt>
<dd><?php echo $item['answer']?></dd>
</dl>
<?php endforeach;?>


