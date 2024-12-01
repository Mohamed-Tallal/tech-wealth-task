# Pattern Analyzer

## Introduction
This application analyzes a string to determine if it follows a specific pattern.

## Backend some knowledge
- **Framework**: Laravel
- **API Endpoint**: `POST /analyze`
- **Logic**: The text is cleaned of spaces and special characters, and checked if it reads the same backward (ignoring case).

## Pattern/Technique Used
The technique used is a **palindrome check**, adjusted to ignore spaces and special characters.
