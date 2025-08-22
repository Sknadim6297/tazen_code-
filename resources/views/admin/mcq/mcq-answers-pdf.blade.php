<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MCQ Answers Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .answer-group {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .group-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .user-info {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .service-info {
            color: #666;
            margin-bottom: 5px;
        }
        
        .professional-info {
            color: #28a745;
            margin-bottom: 5px;
        }
        
        .date-info {
            color: #999;
            font-size: 11px;
        }
        
        .answers-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .answers-table th {
            background: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .answers-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f1f1;
            vertical-align: top;
        }
        
        .answers-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .question-text {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .question-options {
            font-size: 11px;
            color: #666;
            font-style: italic;
        }
        
        .answer-badge {
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-block;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MCQ Answers Report</h1>
        <p>Generated on: {{ date('F d, Y H:i:s') }}</p>
        <p>Total Groups: {{ count($groupedAnswers) }}</p>
    </div>

    @if(count($groupedAnswers) > 0)
        @foreach($groupedAnswers as $key => $group)
        <div class="answer-group">
            <div class="group-header">
                <div class="user-info">
                    👤 {{ $group['user']->name ?? 'N/A' }}
                    @if($group['user']->email)
                        ({{ $group['user']->email }})
                    @endif
                </div>
                <div class="service-info">
                    🛠️ Service: {{ $group['service']->name ?? 'N/A' }}
                </div>
                <div class="professional-info">
                    👩‍⚕️ Professional: 
                    @if($group['professional'] && $group['professional']->profile)
                        {{ $group['professional']->name }}
                        @if($group['professional']->profile->specialization)
                            ({{ $group['professional']->profile->specialization }})
                        @endif
                    @else
                        Not Assigned
                    @endif
                </div>
                <div class="date-info">
                    📅 Answered on: {{ $group['created_at']->format('M d, Y H:i') }}
                </div>
            </div>
            
            <table class="answers-table">
                <thead>
                    <tr>
                        <th width="8%">#</th>
                        <th width="62%">Question</th>
                        <th width="30%">Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group['answers'] as $index => $answer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div class="question-text">{{ $answer->question->question ?? 'Question not found' }}</div>
                            @if($answer->question && $answer->question->options)
                                <div class="question-options">
                                    Options: 
                                    @php
                                        $options = is_string($answer->question->options) ? json_decode($answer->question->options, true) : $answer->question->options;
                                    @endphp
                                    @if(is_array($options))
                                        {{ implode(', ', $options) }}
                                    @else
                                        {{ $answer->question->options }}
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="answer-badge">{{ $answer->answer }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endforeach
    @else
        <div class="no-data">
            <h3>No MCQ answers found</h3>
            <p>There are no MCQ answers matching the selected criteria.</p>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the MCQ Management System</p>
        <p>© {{ date('Y') }} Admin Panel - All rights reserved</p>
    </div>
</body>
</html>
