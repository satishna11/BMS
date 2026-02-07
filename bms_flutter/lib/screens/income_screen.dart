import 'package:flutter/material.dart';

class IncomeScreen extends StatefulWidget {
  const IncomeScreen({super.key});

  @override
  State<IncomeScreen> createState() => _IncomeScreenState();
}

class _IncomeScreenState extends State<IncomeScreen> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[300],
      body: Row(
        children: [
          // Sidebar
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

          // Main content
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
                      "Add Income",
                      style: TextStyle(
                        fontSize: 22,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    const SizedBox(height: 20),
                    inputField("Income Source"),
                    inputField("Amount"),
                    dropdownField("Category", ["Salary", "Business", "Other"]),
                    inputField("Date"),
                    const SizedBox(height: 20),
                    SizedBox(
                      width: 120,
                      height: 40,
                      child: ElevatedButton(
                        onPressed: () {},
                        child: const Text("Submit"),
                      ),
                    )
                  ],
                ),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // Sidebar + Form helpers (same as ExpenseScreen)
  Widget sidebarTitle(String title) => Padding(
        padding: const EdgeInsets.symmetric(vertical: 8),
        child: Text(title, style: const TextStyle(fontWeight: FontWeight.bold)),
      );

  Widget sidebarSection(String title, List<String> items) => Column(
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

  Widget inputField(String label) => Padding(
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

  Widget dropdownField(String label, List<String> items) => Padding(
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
