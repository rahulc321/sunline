@extends('layouts.super')

@section('title','Sales Pipeline')

@section('content')

<style>
/* ================= GLOBAL FIX ================= */
html, body {
    width: 100%;
    height: 100%;
    overflow: hidden;
}

/* ================= PAGE ================= */
.pipeline-page {
    width: 100%;
    height: calc(100vh - 140px); /* adjust if header height changes */
    overflow: hidden;
}

/* ================= PIPELINE WRAPPER ================= */
.pipeline-wrapper {
    width: 100%;
    height: 100%;
    overflow-x: auto;
    overflow-y: hidden;

    scrollbar-width: none;
    -ms-overflow-style: none;
}

.pipeline-wrapper::-webkit-scrollbar {
    display: none;
}

/* ================= PIPELINE ================= */
.pipeline {
    display: grid;
    grid-auto-flow: column;
    grid-auto-columns: minmax(320px, 1fr);
    gap: 20px;
    height: 100%;
    padding: 0 10px;
}

/* ================= COLUMN ================= */
.pipeline-column {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    height: 100%;
}

/* ================= COLUMN HEADER ================= */
.pipeline-header {
    padding: 16px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
    background: #fff;
    border-radius: 14px 14px 0 0;
}

.pipeline-header .count {
    background: #f59e0b;
    color: #fff;
    font-size: 12px;
    padding: 2px 10px;
    border-radius: 999px;
}

.pipeline-header .count.blue { background:#2563eb; }
.pipeline-header .count.orange { background:#f97316; }

/* ================= COLUMN BODY ================= */
.pipeline-body {
    flex: 1;
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    overflow-y: auto;
}

/* ================= CARD ================= */
.pipeline-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px;
    box-shadow: 0 1px 3px rgba(0,0,0,.08);
}

/* ================= CARD CONTENT ================= */
.card-title {
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.priority {
    font-size: 11px;
    padding: 2px 10px;
    border-radius: 999px;
    text-transform: lowercase;
    color: #fff;
}
.priority.high { background:#ef4444; }
.priority.medium { background:#f59e0b; }
.priority.low { background:#22c55e; }

.card-sub {
    color: #6b7280;
    font-size: 13px;
    margin-top: 4px;
}

.card-status {
    display: inline-block;
    margin-top: 8px;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 999px;
    font-weight: 500;
}
.pending { background:#fde68a; color:#92400e; }
.progress { background:#bfdbfe; color:#1e3a8a; }
.warning { background:#fed7aa; color:#9a3412; }

.card-footer {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-size: 12px;
    color: #6b7280;
}

.card-tags {
    margin-top: 8px;
}
.tag {
    border: 1px solid #e5e7eb;
    padding: 2px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 500;
}
</style>

<!-- ================= PAGE HEADER ================= -->
<div class="page-header mb-3">
    <div class="page-header-content d-lg-flex align-items-center justify-content-between">
        <div>
            <h4 class="page-title mb-0 crm_c" style="font-size:1.875rem;">
                Sales Pipeline
            </h4>
            <p class="mb-0 txt_1">
                Manage and track workflow progress
            </p>
        </div>
    </div>
</div>

<!-- ================= PIPELINE ================= -->
<div class="pipeline-page">
    <div class="pipeline-wrapper">
        <div class="pipeline">

            <!-- LEAD -->
            <div class="pipeline-column">
                <div class="pipeline-header">
                    <span>Lead</span>
                    <span class="count">2</span>
                </div>
                <div class="pipeline-body">
                    <div class="pipeline-card">
                        <div class="card-title">
                            6.6kW System - $8,500
                            <span class="priority high">high</span>
                        </div>
                        <div class="card-sub">John Smith</div>
                        <span class="card-status pending">pending</span>
                        <div class="card-footer">
                            <span>Due: 2024-01-20</span>
                            <span>#SP-001</span>
                        </div>
                        <div class="card-tags">
                            <span class="tag">Hot Lead</span>
                        </div>
                    </div>

                    <div class="pipeline-card">
                        <div class="card-title">
                            6.6kW System - $8,500
                            <span class="priority high">high</span>
                        </div>
                        <div class="card-sub">John Smith</div>
                        <span class="card-status pending">pending</span>
                        <div class="card-footer">
                            <span>Due: 2024-01-20</span>
                            <span>#SP-004</span>
                        </div>
                        <div class="card-tags">
                            <span class="tag">Hot Lead</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QUOTE SENT -->
            <div class="pipeline-column">
                <div class="pipeline-header">
                    <span>Quote Sent</span>
                    <span class="count blue">1</span>
                </div>
                <div class="pipeline-body">
                    <div class="pipeline-card">
                        <div class="card-title">
                            8.0kW System - $11,200
                            <span class="priority medium">medium</span>
                        </div>
                        <div class="card-sub">Mike Johnson</div>
                        <span class="card-status progress">progress</span>
                        <div class="card-footer">
                            <span>Due: 2024-01-18</span>
                            <span>#SP-002</span>
                        </div>
                        <div class="card-tags">
                            <span class="tag">Follow-up Required</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NEGOTIATION -->
            <div class="pipeline-column">
                <div class="pipeline-header">
                    <span>Negotiation</span>
                    <span class="count orange">1</span>
                </div>
                <div class="pipeline-body">
                    <div class="pipeline-card">
                        <div class="card-title">
                            5.5kW System - $7,800
                            <span class="priority high">high</span>
                        </div>
                        <div class="card-sub">Lisa Davis</div>
                        <span class="card-status warning">warning</span>
                        <div class="card-footer">
                            <span>Due: 2024-01-17</span>
                            <span>#SP-003</span>
                        </div>
                        <div class="card-tags">
                            <span class="tag">Price Sensitive</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
