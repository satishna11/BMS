import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:http/http.dart' as http;

class ExpenseScreen extends StatefulWidget {
  const ExpenseScreen({super.key});

  @override
  State<ExpenseScreen> createState() => _ExpenseScreenState();
}

class _ExpenseScreenState extends State<ExpenseScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[300],
      body: Row(
        children: [
          // ===== Sidebar =====
          Container(
            width: 220,
            color: Colors.grey[200],
            padding: const EdgeInsets.all(16),
            child: ListView(
              children: [
                sidebarTitle("Dashboard"),
                sidebarSection("Income", ["Add Income", "View Income"]),
                sidebarSection("Expenses", ["Add Expense", "View Expense"]),
                sidebarSection("Budget", ["Add Budget", "View Budget"]),
                sidebarSection("Report", ["View Report"]),
              ],
            ),
          ),

          // ===== Main Content =====
          Expanded(
            child: Center(
              child: Container(
                width: 420,
                padding: const EdgeInsets.all(24),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Column(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    const Text(
                      "Add Expense",
                      style: TextStyle(
                        fontSize: 22,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 20),

                    inputField("Expense Title"),
                    dropdownField("Category", [
                      "Grocery",
                      "Shopping",
                      "Education",
                      "Transport",
                    ]),
                    inputField("Amount"),
                    dropdownField("Payment Method", ["Cash", "Card", "Online"]),
                    inputField("Date"),

                    const SizedBox(height: 20),

                    SizedBox(
                      width: 120,
                      height: 40,
                      child: ElevatedButton(
                        onPressed: () {},
                        child: const Text("Submit"),
                      ),
                    ),
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ===== Sidebar Helpers =====
  Widget sidebarTitle(String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
    );
  }

  Widget sidebarSection(String title, List<String> items) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 12),
        Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
        ...items.map(
          (e) => Padding(
            padding: const EdgeInsets.only(left: 12, top: 6),
            child: Text(e),
          ),
        ),
      ],
    );
  }

  // ===== Form Helpers =====
  Widget inputField(String label) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          SizedBox(width: 140, child: Text(label)),
          Expanded(
            child: TextField(
              decoration: const InputDecoration(
                isDense: true,
                border: OutlineInputBorder(),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget dropdownField(String label, List<String> items) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 8),
      child: Row(
        children: [
          SizedBox(width: 140, child: Text(label)),
          Expanded(
            child: DropdownButtonFormField(
              decoration: const InputDecoration(
                isDense: true,
                border: OutlineInputBorder(),
              ),
              items: items
                  .map((e) => DropdownMenuItem(value: e, child: Text(e)))
                  .toList(),
              onChanged: (value) {},
            ),
          ),
        ],
      ),
    );
  }
}
