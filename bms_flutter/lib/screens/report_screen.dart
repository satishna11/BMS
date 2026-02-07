import 'package:flutter/material.dart';

class ReportScreen extends StatelessWidget {
  const ReportScreen({super.key});

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
                width: 600,
                padding: const EdgeInsets.all(24),
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(16),
                ),
                child: Column(
                  children: [
                    const Text(
                      "Report",
                      style:
                          TextStyle(fontSize: 22, fontWeight: FontWeight.bold),
                    ),
                    const SizedBox(height: 20),
                    Expanded(
                      child: SingleChildScrollView(
                        child: DataTable(
                          columns: const [
                            DataColumn(label: Text("Type")),
                            DataColumn(label: Text("Category")),
                            DataColumn(label: Text("Amount")),
                            DataColumn(label: Text("Date")),
                          ],
                          rows: List.generate(
                            5,
                            (index) => DataRow(
                              cells: [
                                const DataCell(Text("Expense")),
                                const DataCell(Text("Grocery")),
                                const DataCell(Text("2000")),
                                const DataCell(Text("2026-02-07")),
                              ],
                            ),
                          ),
                        ),
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
}
