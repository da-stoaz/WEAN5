import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
import { useMemo, useState } from "react";
import {
  ActivityIndicator,
  Alert,
  KeyboardAvoidingView,
  Modal,
  Platform,
  Pressable,
  RefreshControl,
  SafeAreaView,
  ScrollView,
  StyleSheet,
  Text,
  TextInput,
  View,
} from "react-native";

import { useApiSettings } from "@/lib/api-settings";
import {
  createDevice,
  deleteDevice,
  getDevices,
  updateDevice,
  type Device,
  type DevicePayload,
} from "@/lib/device-api";
import { showError, showSuccess } from "@/lib/toast";

const EMPTY_FORM: DevicePayload = {
  deviceName: "",
  manufacturer: "",
  serialNumber: "",
  description: "",
};

function getErrorMessage(error: unknown): string {
  if (error instanceof Error) {
    return error.message;
  }

  return "Please try again.";
}

function normalizePayload(payload: DevicePayload): DevicePayload {
  return {
    deviceName: payload.deviceName.trim(),
    manufacturer: payload.manufacturer.trim(),
    serialNumber: payload.serialNumber?.trim() || null,
    description: payload.description?.trim() || null,
  };
}

export default function DevicesScreen() {
  const { baseUrl, isHydrating } = useApiSettings();
  const queryClient = useQueryClient();

  const [isModalVisible, setModalVisible] = useState(false);
  const [editingDevice, setEditingDevice] = useState<Device | null>(null);
  const [form, setForm] = useState<DevicePayload>(EMPTY_FORM);
  const [validationMessage, setValidationMessage] = useState<string | null>(null);

  const isConfigured = baseUrl.length > 0;

  const devicesQuery = useQuery({
    queryKey: ["devices", baseUrl],
    queryFn: () => getDevices(baseUrl),
    enabled: isConfigured && !isHydrating,
  });

  const createMutation = useMutation({
    mutationFn: (payload: DevicePayload) => createDevice(baseUrl, payload),
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: ["devices", baseUrl] });
      showSuccess("Device created", "Your inventory is up to date.");
      closeModal();
    },
    onError: (error: unknown) => {
      showError("Create failed", getErrorMessage(error));
    },
  });

  const updateMutation = useMutation({
    mutationFn: ({ id, payload }: { id: string; payload: DevicePayload }) =>
      updateDevice(baseUrl, id, payload),
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: ["devices", baseUrl] });
      showSuccess("Device updated", "Changes were saved.");
      closeModal();
    },
    onError: (error: unknown) => {
      showError("Update failed", getErrorMessage(error));
    },
  });

  const deleteMutation = useMutation({
    mutationFn: (id: string) => deleteDevice(baseUrl, id),
    onSuccess: async () => {
      await queryClient.invalidateQueries({ queryKey: ["devices", baseUrl] });
      showSuccess("Device deleted", "The device was removed.");
    },
    onError: (error: unknown) => {
      showError("Delete failed", getErrorMessage(error));
    },
  });

  const isSaving = createMutation.isPending || updateMutation.isPending;

  const formError = useMemo(() => {
    if (!form.deviceName.trim()) {
      return "Device name is required.";
    }

    if (!form.manufacturer.trim()) {
      return "Manufacturer is required.";
    }

    return null;
  }, [form.deviceName, form.manufacturer]);

  function openCreateModal() {
    setEditingDevice(null);
    setForm(EMPTY_FORM);
    setValidationMessage(null);
    setModalVisible(true);
  }

  function openEditModal(device: Device) {
    setEditingDevice(device);
    setForm({
      deviceName: device.deviceName,
      manufacturer: device.manufacturer,
      serialNumber: device.serialNumber ?? "",
      description: device.description ?? "",
    });
    setValidationMessage(null);
    setModalVisible(true);
  }

  function closeModal() {
    setModalVisible(false);
    setEditingDevice(null);
    setForm(EMPTY_FORM);
    setValidationMessage(null);
  }

  function submitForm() {
    const payload = normalizePayload(form);

    if (!payload.deviceName || !payload.manufacturer) {
      const message = "Device name and manufacturer are required.";
      setValidationMessage(message);
      showError("Validation failed", message);
      return;
    }

    setValidationMessage(null);

    if (editingDevice) {
      updateMutation.mutate({ id: editingDevice.id, payload });
      return;
    }

    createMutation.mutate(payload);
  }

  function confirmDelete(device: Device) {
    Alert.alert(
      "Delete device",
      `Delete ${device.deviceName}? This action cannot be undone.`,
      [
        { text: "Cancel", style: "cancel" },
        {
          text: "Delete",
          style: "destructive",
          onPress: () => deleteMutation.mutate(device.id),
        },
      ],
    );
  }

  if (isHydrating) {
    return (
      <SafeAreaView style={styles.centered}>
        <ActivityIndicator size="large" color="#0EA5A5" />
        <Text style={styles.loadingText}>Loading configuration...</Text>
      </SafeAreaView>
    );
  }

  if (!isConfigured) {
    return (
      <SafeAreaView style={styles.centered}>
        <Text style={styles.title}>Configure API first</Text>
        <Text style={styles.subtitle}>
          Open Settings and enter your API host to start managing devices.
        </Text>
      </SafeAreaView>
    );
  }

  return (
    <SafeAreaView style={styles.screen}>
      <ScrollView
        contentContainerStyle={styles.content}
        refreshControl={
          <RefreshControl
            refreshing={devicesQuery.isFetching}
            onRefresh={() => devicesQuery.refetch()}
            tintColor="#0EA5A5"
          />
        }
      >
        <View style={styles.headerRow}>
          <View>
            <Text style={styles.title}>Devices</Text>
            <Text style={styles.subtitle}>Manage your fleet in one place.</Text>
          </View>

          <Pressable style={styles.primaryButton} onPress={openCreateModal}>
            <Text style={styles.primaryButtonText}>+ Add</Text>
          </Pressable>
        </View>

        {devicesQuery.isLoading ? (
          <View style={styles.loadingContainer}>
            <ActivityIndicator size="small" color="#0EA5A5" />
            <Text style={styles.loadingText}>Fetching devices...</Text>
          </View>
        ) : null}

        {devicesQuery.isError ? (
          <View style={styles.errorCard}>
            <Text style={styles.errorTitle}>Could not load devices</Text>
            <Text style={styles.errorBody}>
              {getErrorMessage(devicesQuery.error)}
            </Text>
            <Pressable
              style={styles.secondaryButton}
              onPress={() => devicesQuery.refetch()}
            >
              <Text style={styles.secondaryButtonText}>Retry</Text>
            </Pressable>
          </View>
        ) : null}

        {!devicesQuery.isLoading &&
        !devicesQuery.isError &&
        (devicesQuery.data?.length ?? 0) === 0 ? (
          <View style={styles.emptyCard}>
            <Text style={styles.emptyTitle}>No devices yet</Text>
            <Text style={styles.emptyBody}>
              Add your first device to start tracking inventory.
            </Text>
          </View>
        ) : null}

        {devicesQuery.data?.map((device) => (
          <View key={device.id} style={styles.deviceCard}>
            <Text style={styles.deviceName}>{device.deviceName}</Text>
            <Text style={styles.deviceMeta}>Manufacturer: {device.manufacturer}</Text>
            <Text style={styles.deviceMeta}>
              Serial: {device.serialNumber || "Not provided"}
            </Text>
            <Text style={styles.deviceDescription}>
              {device.description || "No description"}
            </Text>

            <View style={styles.cardActions}>
              <Pressable
                style={styles.secondaryButton}
                onPress={() => openEditModal(device)}
              >
                <Text style={styles.secondaryButtonText}>Edit</Text>
              </Pressable>

              <Pressable
                style={styles.deleteButton}
                onPress={() => confirmDelete(device)}
                disabled={deleteMutation.isPending}
              >
                <Text style={styles.deleteButtonText}>Delete</Text>
              </Pressable>
            </View>
          </View>
        ))}
      </ScrollView>

      <Modal
        animationType="slide"
        visible={isModalVisible}
        presentationStyle={Platform.OS === "ios" ? "pageSheet" : "fullScreen"}
        allowSwipeDismissal
        onRequestClose={closeModal}
      >
        <SafeAreaView style={styles.modalScreen}>
          <KeyboardAvoidingView
            behavior={Platform.OS === "ios" ? "padding" : undefined}
            style={styles.modalKeyboard}
          >
            <ScrollView
              contentContainerStyle={styles.modalContent}
              keyboardShouldPersistTaps="handled"
            >
              <View style={styles.modalCard}>
                <Text style={styles.modalTitle}>
                  {editingDevice ? "Update device" : "Create device"}
                </Text>

                <View style={styles.fieldGroup}>
                  <Text style={styles.fieldLabel}>
                    Device name
                    <Text style={styles.requiredMark}> *</Text>
                  </Text>
                  <TextInput
                    style={styles.input}
                    value={form.deviceName}
                    onChangeText={(deviceName) =>
                      setForm((prev) => ({ ...prev, deviceName }))
                    }
                    placeholder="e.g., iPhone 16 Pro Max"
                    placeholderTextColor="#64748B"
                  />
                </View>

                <View style={styles.fieldGroup}>
                  <Text style={styles.fieldLabel}>
                    Manufacturer
                    <Text style={styles.requiredMark}> *</Text>
                  </Text>
                  <TextInput
                    style={styles.input}
                    value={form.manufacturer}
                    onChangeText={(manufacturer) =>
                      setForm((prev) => ({ ...prev, manufacturer }))
                    }
                    placeholder="e.g., Apple"
                    placeholderTextColor="#64748B"
                  />
                </View>

                <View style={styles.fieldGroup}>
                  <Text style={styles.fieldLabel}>Serial number</Text>
                  <TextInput
                    style={styles.input}
                    value={form.serialNumber ?? ""}
                    onChangeText={(serialNumber) =>
                      setForm((prev) => ({ ...prev, serialNumber }))
                    }
                    placeholder="e.g., ABCDEFGH-013333"
                    placeholderTextColor="#64748B"
                  />
                </View>

                <View style={styles.fieldGroup}>
                  <Text style={styles.fieldLabel}>Description</Text>
                  <TextInput
                    style={[styles.input, styles.multilineInput]}
                    value={form.description ?? ""}
                    onChangeText={(description) =>
                      setForm((prev) => ({ ...prev, description }))
                    }
                    placeholder="Short notes about this device"
                    placeholderTextColor="#64748B"
                    multiline
                  />
                </View>

                {validationMessage || formError ? (
                  <Text style={styles.formError}>
                    {validationMessage ?? formError}
                  </Text>
                ) : null}

                <View style={styles.modalActions}>
                  <Pressable style={styles.secondaryButton} onPress={closeModal}>
                    <Text style={styles.secondaryButtonText}>Cancel</Text>
                  </Pressable>

                  <Pressable
                    style={[styles.primaryButton, isSaving && styles.disabledButton]}
                    onPress={submitForm}
                    disabled={isSaving}
                  >
                    <Text style={styles.primaryButtonText}>
                      {isSaving ? "Saving..." : "Save"}
                    </Text>
                  </Pressable>
                </View>
              </View>
            </ScrollView>
          </KeyboardAvoidingView>
        </SafeAreaView>
      </Modal>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  screen: {
    flex: 1,
    backgroundColor: "#F4F8FB",
  },
  centered: {
    flex: 1,
    alignItems: "center",
    justifyContent: "center",
    padding: 24,
    backgroundColor: "#F4F8FB",
  },
  content: {
    padding: 16,
    gap: 12,
    paddingBottom: 28,
  },
  headerRow: {
    flexDirection: "row",
    justifyContent: "space-between",
    alignItems: "center",
    marginBottom: 6,
  },
  title: {
    fontSize: 30,
    fontWeight: "800",
    color: "#0F172A",
    letterSpacing: -0.6,
  },
  subtitle: {
    marginTop: 4,
    fontSize: 14,
    color: "#334155",
  },
  loadingContainer: {
    padding: 16,
    borderRadius: 14,
    backgroundColor: "#FFFFFF",
    borderWidth: 1,
    borderColor: "#DBEAFE",
    gap: 6,
  },
  loadingText: {
    fontSize: 14,
    color: "#334155",
  },
  errorCard: {
    borderRadius: 16,
    borderWidth: 1,
    borderColor: "#FECACA",
    backgroundColor: "#FFF5F7",
    padding: 14,
    gap: 8,
  },
  errorTitle: {
    fontWeight: "700",
    fontSize: 16,
    color: "#7F1D1D",
  },
  errorBody: {
    color: "#9F1239",
    fontSize: 13,
  },
  emptyCard: {
    borderRadius: 16,
    borderWidth: 1,
    borderColor: "#BFDBFE",
    backgroundColor: "#F0F9FF",
    padding: 16,
    gap: 8,
  },
  emptyTitle: {
    fontWeight: "700",
    fontSize: 16,
    color: "#0C4A6E",
  },
  emptyBody: {
    color: "#155E75",
    fontSize: 13,
  },
  deviceCard: {
    borderRadius: 16,
    padding: 14,
    backgroundColor: "#FFFFFF",
    borderWidth: 1,
    borderColor: "#E2E8F0",
    shadowColor: "#0F172A",
    shadowOpacity: 0.04,
    shadowOffset: { width: 0, height: 8 },
    shadowRadius: 16,
    elevation: 2,
    gap: 4,
  },
  deviceName: {
    fontSize: 18,
    fontWeight: "700",
    color: "#111827",
  },
  deviceMeta: {
    fontSize: 13,
    color: "#334155",
  },
  deviceDescription: {
    marginTop: 4,
    fontSize: 13,
    color: "#475569",
  },
  cardActions: {
    flexDirection: "row",
    gap: 8,
    marginTop: 10,
  },
  primaryButton: {
    minWidth: 88,
    borderRadius: 12,
    backgroundColor: "#0EA5A5",
    paddingVertical: 10,
    paddingHorizontal: 14,
    alignItems: "center",
  },
  primaryButtonText: {
    color: "#F8FAFC",
    fontSize: 14,
    fontWeight: "700",
  },
  secondaryButton: {
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#CBD5E1",
    backgroundColor: "#F8FAFC",
    paddingVertical: 10,
    paddingHorizontal: 14,
    alignItems: "center",
  },
  secondaryButtonText: {
    color: "#0F172A",
    fontSize: 13,
    fontWeight: "600",
  },
  deleteButton: {
    borderRadius: 12,
    borderWidth: 1,
    borderColor: "#FCA5A5",
    backgroundColor: "#FFF1F2",
    paddingVertical: 10,
    paddingHorizontal: 14,
    alignItems: "center",
  },
  deleteButtonText: {
    color: "#B91C1C",
    fontSize: 13,
    fontWeight: "600",
  },
  modalScreen: {
    flex: 1,
    backgroundColor: "#F4F8FB",
  },
  modalKeyboard: {
    flex: 1,
  },
  modalContent: {
    flexGrow: 1,
    justifyContent: "flex-start",
    paddingHorizontal: 18,
    paddingTop: 54,
    paddingBottom: 28,
  },
  modalCard: {
    borderRadius: 20,
    backgroundColor: "#FFFFFF",
    padding: 18,
    shadowColor: "#0F172A",
    shadowOpacity: 0.06,
    shadowRadius: 12,
    shadowOffset: { width: 0, height: 6 },
    elevation: 1,
  },
  modalTitle: {
    fontSize: 22,
    fontWeight: "700",
    color: "#0F172A",
    marginBottom: 16,
  },
  fieldGroup: {
    marginBottom: 12,
  },
  fieldLabel: {
    fontSize: 13,
    fontWeight: "600",
    color: "#334155",
    marginBottom: 6,
  },
  requiredMark: {
    color: "#B91C1C",
  },
  input: {
    borderWidth: 1,
    borderColor: "#D4DEE8",
    borderRadius: 12,
    paddingHorizontal: 12,
    height: 50,
    fontSize: 17,
    color: "#0F172A",
    backgroundColor: "#F8FAFC",
  },
  multilineInput: {
    height: 118,
    paddingTop: 12,
    textAlignVertical: "top",
  },
  modalActions: {
    marginTop: 6,
    flexDirection: "row",
    justifyContent: "flex-end",
    gap: 10,
  },
  formError: {
    color: "#B91C1C",
    fontSize: 12,
    fontWeight: "600",
  },
  disabledButton: {
    opacity: 0.6,
  },
});
