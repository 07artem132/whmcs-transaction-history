<h4>Нажмите на транзакцию, чтобы открыть соответствующий счёт (если тот существует)</h4>
<table class="table table-list dataTable no-footer dtr-inline">
    <thead>
    <tr>
        <td style="width: 85px;">ID счета</td>
        <td style="width: 95px;">Дата</td>
        <td>Описание</td>
        <td>Сумма</td>
        <td>Баланс</td>
    </tr>
    </thead>
    {foreach from=$credits item=credit}
        {if isset($credit['invoiceId'])}
            <tr onclick="clickableSafeRedirect(event, 'viewinvoice.php?id={$credit['invoiceId']}', false)">
                {else}
            <tr>
        {/if}
        <td style="width: 85px;">{$credit['invoiceId']}</td>
        <td style="width: 95px;">{$credit['date']}</td>
        <td>{$credit['invoiceItems']}</td>
        <td>{$credit['amount']}</td>
        <td>{$credit['balance']}</td>
        </tr>
    {/foreach}
</table>