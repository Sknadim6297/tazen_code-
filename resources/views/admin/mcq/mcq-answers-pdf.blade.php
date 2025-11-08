<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MCQ Answers Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }
        
        .page {
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 12px;
        }
        
        .header h1 {
            color: #667eea;
            font-size: 22px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .header .meta {
            font-size: 9px;
            color: #666;
            margin-top: 5px;
        }
        
        .answer-group {
            margin-bottom: 20px;
            page-break-inside: avoid;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .group-header {
            background: #f8f9fa;
            padding: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #555;
            width: 80px;
            font-size: 9px;
        }
        
        .info-value {
            display: table-cell;
            color: #333;
            font-size: 9px;
        }
        
        .user-name {
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }
        
        .service-badge {
            background: #17a2b8;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            display: inline-block;
        }
        
        .professional-badge {
            background: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            display: inline-block;
        }
        
        .not-assigned {
            background: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            display: inline-block;
        }
        
        .answers-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: white;
        }
        
        .answers-table thead {
            background: #667eea;
        }
        
        .answers-table th {
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 9px;
            border: 1px solid #5568d3;
        }
        
        .answers-table td {
            padding: 8px 6px;
            border: 1px solid #e9ecef;
            vertical-align: top;
            font-size: 9px;
        }
        
        .answers-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .answers-table tbody tr:hover {
            background: #e9ecef;
        }
        
        .question-number {
            font-weight: bold;
            color: #667eea;
            text-align: center;
        }
        
        .question-cell {
            line-height: 1.5;
        }
        
        .question-text {
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            display: block;
        }
        
        .question-options {
            font-size: 8px;
            color: #666;
            font-style: italic;
            margin-top: 3px;
            padding-left: 8px;
        }
        
        .answer-cell {
            font-weight: 600;
            color: #667eea;
            word-wrap: break-word;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 11px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #e9ecef;
            color: #666;
            font-size: 8px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>MCQ Answers Report</h1>
            <div class="meta">
                <strong>Generated:</strong> {{ date('F d, Y H:i:s') }} | 
                <strong>Total Groups:</strong> {{ count($groupedAnswers) }} | 
                <strong>Total Answers:</strong> {{ array_sum(array_map(function($g) { return count($g['answers']); }, $groupedAnswers)) }}
            </div>
        </div>

        @if(count($groupedAnswers) > 0)
            @foreach($groupedAnswers as $key => $group)
            <div class="answer-group">
                <div class="group-header">
                    <div class="info-row">
                        <span class="info-label">Customer:</span>
                        <span class="info-value">
                            <span class="user-name">{{ $group['user']->name ?? 'N/A' }}</span>
                            @if($group['user']->email)
                                <span style="color: #666;"> ({{ $group['user']->email }})</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Service:</span>
                        <span class="info-value">
                            <span class="service-badge">{{ $group['service']->name ?? 'N/A' }}</span>
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Professional:</span>
                        <span class="info-value">
                            @if($group['professional'] && $group['professional']->profile)
                                <span class="professional-badge">{{ $group['professional']->name }}</span>
                                @if($group['professional']->profile->specialization)
                                    <span style="color: #666; font-size: 8px;"> ({{ $group['professional']->profile->specialization }})</span>
                                @endif
                            @else
                                <span class="not-assigned">Not Assigned</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Answered on:</span>
                        <span class="info-value" style="color: #666;">{{ $group['created_at']->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                
                <table class="answers-table">
                    <thead>
                        <tr>
                            <th style="width: 70%;">Question</th>
                            <th style="width: 30%;">Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group['answers'] as $index => $answer)
                        <tr>
                            <td class="question-cell">
                                <span class="question-text">{{ $answer->serviceMcq->question ?? 'Question not found' }}</span>
                                @if($answer->serviceMcq && isset($answer->serviceMcq->options) && $answer->serviceMcq->options)
                                    <div class="question-options">
                                        Options: 
                                        @php
                                            $options = is_array($answer->serviceMcq->options) ? $answer->serviceMcq->options : json_decode($answer->serviceMcq->options, true);
                                        @endphp
                                        @if(is_array($options) && !empty($options))
                                            {{ implode(', ', $options) }}
                                        @elseif(is_string($answer->serviceMcq->options))
                                            {{ $answer->serviceMcq->options }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="answer-cell">{{ $answer->selected_answer ?? 'No answer' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        @else
            <div class="no-data">
                <strong>No MCQ Answers Found</strong>
                <p>There are no MCQ answers matching the selected criteria.</p>
            </div>
        @endif

        <div class="footer">
            <p><strong>MCQ Management System</strong> - Generated automatically on {{ date('F d, Y H:i:s') }}</p>
            <p>&copy; {{ date('Y') }} Admin Panel. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
