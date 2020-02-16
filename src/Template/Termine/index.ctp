<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Termine[]|\Cake\Collection\CollectionInterface $termine
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        
        <li><?= $this->Html->link(__('Neuer Termin'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="termine index large-9 medium-8 columns content">
    <h3><?= __('Alle Termine') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <!-- <th scope="col"><?= $this->Paginator->sort('id') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('beginn') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ende') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ort') ?></th>
                <th scope="col"><?= $this->Paginator->sort('typ') ?></th>
                <th scope="col"><?= $this->Paginator->sort('details') ?></th>
                <!--TODO: die Felder aus der Tabelle TerminDetails müssten hier eingefügt werden.-->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($termine as $termin): ?>
            <tr>
                    <!-- Uninteressant für Menschen, die das einsehen wollen -->
                    <!-- <td><?= $this->Number->format($termin->id) ?></td> -->
                <td><?= h($termin->beginn) ?></td> <!--TODO: MEZ-Zeitformat-->
                <td><?= h($termin->ende) ?></td>
                <td><?= $this->Number->format($termin->stamm_orte->ort) ?></td> <!--warum greift er hier nicht auf den Ort in Stammorte zu?-->
                <td><?= h($termin->typ) ?></td>
                <td><?= $this->Number->format($termin->details) ?></td>
                <!--TODO: die Felder aus der Tabelle TerminDetails müssten hier eingefügt werden.-->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $termin->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $termin->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $termin->id], ['confirm' => __('Are you sure you want to delete # {0}?', $termin->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
