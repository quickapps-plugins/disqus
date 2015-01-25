<fieldset>
    <legend><?php echo __d('disqus', 'Disqus Settings'); ?></legend>

    <?php echo $this->Form->input('api_key', ['type' => 'text', 'label' => __d('disqus', 'API Key')]); ?>
    <em class="help-block"><?php echo __d('disqus', 'Disqus API Key, register <a href="{0}">here</a>', $this->Html->url('https://disqus.com/api/applications/register/')); ?></em>

    <?php echo $this->Form->input('disqus_shortname', ['type' => 'text', 'label' => __d('disqus', 'disqus_shortname')]); ?>
    <em class="help-block"><?php echo __d('disqus', "Tells the Disqus service your forum's shortname, which is the unique identifier for your website as registered on Disqus. If undefined, the Disqus embed will not load."); ?></em>
</fieldset>