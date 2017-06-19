<div class="well with-header with-footer">
                                <div class="header bordered-sky">
                                    我的客户
                                </div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                客户名称
                                            </th>
                                            <th>
                                                订单数量
                                            </th>
                                            <th>
                                                最后下单时间
                                            </th>
                                            <th>
                                                在线状态
                                            </th>
                                            <th>
                                                联系方式
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                           
                                    <?php foreach ($cust_info as $item): ?>
                                        <tr>
                                            <td>
                                                <?php echo $item['nickname']?>
                                            </td>
                                            <td>
                                               <?php echo $item['amount']?>
                                            </td>
                                            <td>
                                                <?php echo $item['addtime']?>
                                            </td>
                                            <td>
                                                在线
                                            </td>
                                            <td class="danger">
                                                <?php echo $item['mobile']?>
                                            </td>
                                        </tr>
                                        <?php endforeach;?>
                                        
                                    </tbody>
                                </table>
                                
                            </div>