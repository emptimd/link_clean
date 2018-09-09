<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1">
        <style>
            body{;width:100% !important;min-width: 100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;height:100%;}
            img {margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;outline:none;-ms-interpolation-mode: bicubic;}
            p {margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;}
            @media only screen and (max-width: 600px) {table[class="steps"] {display: table-caption;}}
        </style>
    </head>
<body>
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="max-width:800px; min-width:800px;">
    <tr>
        <td>

            <!-- header -->
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#30507e">
                <tr>
                    <td>
                        <table width="90%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#30507e" style="width:90%;">
                            <tr>
                                <td>
                                    <img align="center" src="{{ url('/') }}/theme/img/logo20.png" alt="" width="210" style="background-color:#30507e; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;"></td>
                                <td>
                                    <p align="right" style="max-width:100%; color:#000000;font-size:24px;line-height:59px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#ffffff;">
                                        Backlinks Analysis Report
                                    </p>
                                </td>
                            </tr>
                        </table>

                        <table width="90%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#30507e" style="width:90%;">
                            <tr>
                                <td>
                                    <img align="right" src="{{ url('/') }}/theme/img/calendar.png" alt="" width="19" style="background-color:#30507e; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;"></td>
                                <td width="100">
                                    <p align="right" style="max-width:100%; color:#30507e;font-size:18px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#ffffff;">
                                        {{ $date }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:16px"></td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <!-- end header -->

            <!-- info -->
            <table width="93%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:93%;">
                <tr>
                    <td colspan="3" style="padding: 10px 0; height:21px; text-align: center;">
                        <a href="#" style="font-size: 20px; color: #FF5722; text-decoration: none;">{{ $url }}</a>
                    </td>
                </tr>
                <tr>
                    <td style="width:250px; vertical-align:top;">
                        <!-- pie -->
                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                            <tr>
                                <td>
                                    <img align="left" src="http://chart.googleapis.com/chart?cht=p&chs=250x230&chd=s:bad|critical|good&chd=t:{{ $totals->bad_percent }},{{ $totals->critical_percent }},{{ $totals->good_percent }}&chco=ff3f3f|000000|b2e122&chxs=0,ff000,12,0,lt|1,0000ff,10,1,lt" alt="" width="250" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                </td>
                            </tr>
                        </table>
                        <!-- end pie -->
                    </td>
                    <td style="vertical-align:top; width:275px;">

                        <!-- pie info -->
                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                            <tr>
                                <td>
                                    <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                                        <tr>
                                            <td style="height: 15px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px; background-color:#4f9ee1"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:16px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#8a8a8a;">Total Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height:9px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px;"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:24px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">
                                                    {{ number_format($totals->total) }}
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                                        <tr>
                                            <td style="height: 30px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px; background-color:#b2e122"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:16px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#8a8a8a;">Good Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height:9px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px;"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:24px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">
                                                    {{ number_format($totals->good) }} ({{ $totals->good_percent }}%)
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                                        <tr>
                                            <td style="height: 30px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px; background-color:#ff3f3f"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:16px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#8a8a8a;">Bad Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height:9px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px;"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:24px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">
                                                    {{ number_format($totals->bad) }} ({{ $totals->bad_percent }}%)
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                                        <tr>
                                            <td style="height: 30px"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px; background-color:#000000"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:16px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#8a8a8a;">Critical Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" style="height:9px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:13px"></td>
                                            <td style="width:17px; height:17px; border-radius:3px;"></td>
                                            <td style="width:6px"></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:24px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">
                                                    {{ number_format($totals->critical) }} ({{ $totals->critical_percent }}%)
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <!-- pie info end -->
                    </td>
                    <td style="vertical-align: top;">
                        <!-- penalty -->
                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                            <tr>
                                <td colspan="2" style="height:37px">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p align="left" style="max-width:100%;font-size:34px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a;">Penalty Risk</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height:25px;"></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p align="center" style="max-width:90%;font-size:91px;line-height:96px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#fe4f16;">
                                        {{ $totals->penalty_risk }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="31">
                                    <a href="" style="border:0; outline:none; text-decoration:none; color:#ffffff;">
                                        <img align="left" src="{{ url('/') }}/theme/img/question.png" alt="" width="22" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                    </a>
                                </td>
                                <td>
                                    <p align="left" style="max-width:100%;font-size:16px;line-height:18px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#8a8a8a;">What is the penalty risk</p>
                                </td>
                            </tr>
                        </table>
                        <!-- end penalty -->
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="height:21px;"></td>
                </tr>
            </table>
            <!-- end info -->

            <?php if(false) { // TODO: remove false ?>
            <!-- bottom chart -->
            <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="width:100%;">
                <tr>
                    <td colspan="2" height="38px">

                    </td>
                </tr>
                <tr>
                    <td colspan="2" height="41px" style="background-color:#f8f8f8;">

                    </td>
                </tr>
                <tr>
                    <td style="background-color:red">
                        <!-- table bottom -->
                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#f8f8f8" style="width:100%;">
                            <tr>
                                <td style="width:26px"></td>
                                <td>
                                    <p align="left" style="max-width:100%;font-size:22px;line-height:24px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">Backlinks Progress Bar</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="height:20px;"></td>
                            </tr>
                            <tr>
                                <td style="width:53px"></td>
                                <td>
                                    <table width="80%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="box-shadow: 0px 0px 9px 0px rgba(0, 0, 0, 0.18);width:80%;">
                                        <tr>
                                            <th colspan="" style="background-color: #ebe8e8; line-height:35px;width:39px"></th>
                                            <th style="width:0px"></th>
                                            <th style="width:80px; text-align:left; background-color: #ebe8e8; line-height:35px; color:#4a4a4a">This week</th>
                                            <th style="background-color: #ebe8e8; line-height:35px;width:44px"></th>
                                            <th style="width:83px; background-color: #ebe8e8; line-height:35px; color:#4a4a4a">This month</th>
                                            <th style="background-color: #ebe8e8; line-height:35px;"" colspan="2"></th>
                                        </tr>
                                        <tr>
                                            <td colspan="7" style="height:8px"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">
                                                <img align="center" src="{{ url('/') }}/theme/img/table-icon1.png" alt="" width="15" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td style="width:23px"></td>
                                            <td>
                                                <p align="left" style="max-width:94%;font-size:13px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4f9ee1; font-weight:bold;">Total Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" style="height:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">
                                                <img align="center" src="{{ url('/') }}/theme/img/table-icon2.png" alt="" width="15" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td style="width:23px"></td>
                                            <td>
                                                <p align="left" style="max-width:94%;font-size:13px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#b2e122; font-weight:bold;">Good Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" style="height:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">
                                                <img align="center" src="{{ url('/') }}/theme/img/table-icon3.png" alt="" width="15" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td style="width:23px"></td>
                                            <td>
                                                <p align="left" style="max-width:94%;font-size:13px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#ff5353; font-weight:bold;">Bad Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" style="height:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">
                                                <img align="center" src="{{ url('/') }}/theme/img/table-icon4.png" alt="" width="15" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10.300(-2%)</p>
                                            </td>
                                            <td style="width:23px"></td>
                                            <td>
                                                <p align="left" style="max-width:94%;font-size:13px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#000000; font-weight:bold;">Critical Backlinks</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" style="height:12px"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center">
                                                <img align="center" src="{{ url('/') }}/theme/img/table-icon5.png" alt="" width="15" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">12(-2%)</p>
                                            </td>
                                            <td></td>
                                            <td>
                                                <p align="left" style="max-width:100%;font-size:14px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">10(-2%)</p>
                                            </td>
                                            <td style="width:23px"></td>
                                            <td>
                                                <p align="left" style="max-width:94%;font-size:13px;line-height:25px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#ff8c3f; font-weight:bold;">Penalty Backlinks</p>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    <td style="vertical-align:top; width:260px; background-color:#f8f8f8">
                        <!-- chart bottom right -->
                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#f8f8f8" style="width:100%;">
                            <tr>
                                <td>
                                    <p align="left" style="max-width:100%;font-size:22px;line-height:24px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#4a4a4a; font-weight:bold;">Bad Links Chart</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:20px;"></td>
                            </tr>
                            <tr>
                                <td>
                                    <img align="left" src="http://chart.googleapis.com/chart?cht=bvg&chs=200x150&chl=aug|sept|oct|nov|dec&chf=bg,s,f8f8f8&chd=t:20,30,25,10,15&chxt=x,y&chco=ff3f3f&chxs=0,ff0000,12,0,lt|1,0000ff,10,1,lt" alt="" width="230" style="background-color:#ffffff; color:#ffffff;font-size:22px; font-weight:bold; font-family: Arial, Helvetica, sans-serif;margin-left:0;margin-right:0;margin-top:0;margin-bottom:0;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;">
                                </td>
                            </tr>
                            <tr>
                                <td style="height:10px;"></td>
                            </tr>
                            <tr>
                                <td style="text-align:center">
                                    <select name="" id="" style="width:120px;">
                                        <option value="">Monthly</option>
                                        <option value="">Weekly</option>
                                        <option value="">Daily</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <!-- end chart bottom right -->
                    </td>
                    <!-- end table bottom -->
                    </td>
                </tr>
            </table>
            <!-- end bottom chart -->

            <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="background-color:#f8f8f8; height:47px"></td>
    </tr>
    <tr>
        <td style="text-align:center; font-size:25px; background-color:#f8f8f8">
            <a href="<?= $user_id?url('campaign/'.$campaign_id):url('demo/'.$campaign_id)?>" style="border:0; outline:none; text-decoration:underline; color:#f74e13;">
                To get detailed link report Click Here
            </a>
        </td>
    </tr>
    <tr>
        <td style="background-color:#f8f8f8; height:40px"></td>
    </tr>
    <tr>
        <td style="background-color:#112643; text-align:center">
            <p align="center" style="max-width:100%;font-size:16px;line-height:54px;font-family: Arial, Helvetica, sans-serif; margin-bottom:0; margin-top:0; margin-left:0; margin-right:0; padding-bottom:0; padding-top:0; padding-left:0; padding-right:0; color:#ffffff; font-weight:bold;">(c) Linkquidator 2013-2017</p>
        </td>
    </tr>
</table>
</body>
</html>