@extends('layouts.app')

@section('title', 'Wallet Dashboard')
@section('pagetitle', 'Wallet Overview')

@section('content')

    <style>
        .wallet-bg {
            background: #f4f7fa;
            padding: 30px;
            border-radius: 20px;
        }

        .wallet-card-pro {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .wallet-card-pro:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px -5px rgba(0, 0, 0, 0.1);
        }

        /* Dynamic Accent Borders & Icons */
        .wallet-card-pro::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 5px;
            background: var(--accent-color, #5f63f2);
            border-radius: 16px 0 0 16px;
        }

        .wallet-icon-soft {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            background: var(--bg-soft, #f0f1ff);
            color: var(--accent-color, #5f63f2);
            transition: all 0.3s ease;
        }

        .wallet-card-pro:hover .wallet-icon-soft {
            background: var(--accent-color, #5f63f2);
            color: #fff;
            transform: rotate(10deg);
        }

        .wallet-title-pro {
            font-size: 12px;
            font-weight: 700;
            color: #8a94ad;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .wallet-amount-pro {
            font-size: 24px;
            font-weight: 800;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .currency-symbol {
            font-size: 16px;
            color: #a0aec0;
            font-weight: 600;
        }

        /* Color Variations */
        .color-main { --accent-color: #4e73df; --bg-soft: #eaeeff; }
        .color-cc { --accent-color: #6f42c1; --bg-soft: #f3effb; }
        .color-matm { --accent-color: #fd7e14; --bg-soft: #fff3eb; }
        .color-nsdl { --accent-color: #20c997; --bg-soft: #e9f9f4; }
        .color-aeps { --accent-color: #6610f2; --bg-soft: #f0eaff; }
        .color-comm { --accent-color: #28a745; --bg-soft: #eaf6ec; }
        .color-reward { --accent-color: #e83e8c; --bg-soft: #fdeef5; }
        .color-lock { --accent-color: #dc3545; --bg-soft: #fbebed; }
        .color-aeps-lock { --accent-color: #ffc107; --bg-soft: #fff9e6; }
        .color-cc-lock { --accent-color: #6c757d; --bg-soft: #f1f3f5; }
        .color-total { --accent-color: #1a202c; --bg-soft: #edf2f7; }

    </style>

    @php
        $total = array_sum($wallets);
        
        // Helper function for specific colors
        function getWalletTheme($title) {
            return match (trim($title)) {
                'Main Wallet'        => 'color-main',
                'CC Wallet'          => 'color-cc',
                'Micro ATM Balance'  => 'color-matm',
                'NSDL Wallet'        => 'color-nsdl',
                'AEPS Balance'       => 'color-aeps',
                'Commission Wallet'  => 'color-comm',
                'Reward Wallet'      => 'color-reward',
                'Locked Amount'      => 'color-lock',
                'AEPS Locked Amount' => 'color-aeps-lock',
                'CC Locked Amount'   => 'color-cc-lock',
                default             => 'color-main'
            };
        }
    @endphp

    <div class="wallet-bg">
        <div class="row g-4">
            {{-- TOTAL SECTION --}}
            <div class="col-xl-4 col-md-6 col-12">
                <div class="wallet-card-pro color-total">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="wallet-title-pro">Total Assets Value</div>
                            <div class="wallet-amount-pro">
                                <span class="currency-symbol">₹</span>{{ number_format($total, 2) }}
                            </div>
                        </div>

                        <div class="wallet-icon-soft">
                            <i class="ti ti-building-bank"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WALLET CARDS --}}
            @foreach ($wallets as $title => $amount)
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="wallet-card-pro {{ getWalletTheme($title) }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="wallet-title-pro">
                                    {{ str_replace('_', ' ', $title) }}
                                </div>
                                <div class="wallet-amount-pro">
                                    <span class="currency-symbol">₹</span>{{ number_format($amount, 2) }}
                                </div>
                            </div>

                            <div class="wallet-icon-soft">
                                <i class="ti {{ match(trim($title)) {
                                    'Main Wallet'        => 'ti-wallet',
                                    'CC Wallet'          => 'ti-credit-card',
                                    'Micro ATM Balance'  => 'ti-device-mobile',
                                    'NSDL Wallet'        => 'ti-file-invoice',
                                    'AEPS Balance'       => 'ti-fingerprint',
                                    'Commission Wallet'  => 'ti-chart-bar',
                                    'Reward Wallet'      => 'ti-gift',
                                    'Locked Amount'      => 'ti-lock-off',
                                    'AEPS Locked Amount' => 'ti-lock',
                                    'CC Locked Amount'   => 'ti-lock-access',
                                    default             => 'ti-cash-banknote'
                                } }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

