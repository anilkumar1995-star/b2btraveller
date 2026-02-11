@extends('layouts.app')

@section('title', 'Wallet Dashboard')
@section('pagetitle', 'Wallet Overview')

@section('content')

    <style>
        .wallet-card-pro {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #eef1f6;
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        /* LEFT ACCENT BORDER */
        .wallet-card-pro::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: #5f63f2;
            /* soft professional blue */
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .wallet-total-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            border: 1px solid #f2f2f2;
        }

        .wallet-total-box small {
            color: #6c757d;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .wallet-total-box h2 {
            font-size: 34px;
            font-weight: 700;
            margin-top: 10px;
            color: #111;
        }

        .wallet-card-pro {
            background: #ffffff;
            border-radius: 14px;
            padding: 22px;
            border: 1px solid #f1f1f1;
            transition: all .3s ease;
            position: relative;
        }

        .wallet-card-pro:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        .wallet-title-pro {
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
            letter-spacing: .6px;
        }

        .wallet-amount-pro {
            font-size: 22px;
            font-weight: 700;
            margin-top: 6px;
            color: #2c3e50;
        }

        .wallet-icon-soft {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: #f4f6fa;
            color: #5f63f2;
        }

        .wallet-bg {
            background: #f8f9fc;
            padding: 25px;
            border-radius: 18px;
        }
    </style>

    @php
        $total = array_sum($wallets);
    @endphp

    <div class="wallet-bg">
        <div class="row">
            {{-- TOTAL SECTION --}}
            <div class="col-xl-4 col-md-6 col-12 mb-4">
                <div class="wallet-card-pro">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="wallet-title-pro">
                                Total Wallet Balance
                            </div>
                            <div class="wallet-amount-pro">
                                ₹ {{ number_format($total, 2) }}
                            </div>
                        </div>

                        <div class="wallet-icon-soft">
                            <i class="ti ti-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WALLET CARDS --}}

            @foreach ($wallets as $title => $amount)
                <div class="col-xl-4 col-md-6 col-12 mb-4">
                    <div class="wallet-card-pro">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="wallet-title-pro">
                                    {{ strtoupper(str_replace('_', ' ', $title)) }}
                                </div>
                                <div class="wallet-amount-pro">
                                    ₹ {{ number_format($amount, 2) }}
                                </div>
                            </div>

                            <div class="wallet-icon-soft">
                                <i class="ti ti-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>


@endsection
